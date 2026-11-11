<?php

namespace App\Controllers;

use App\Models\CartItemModel;
use App\Models\OrderItemModel;
use App\Models\OrderModel;
use App\Models\ProductModel;
use App\Models\UserModel;
use Config\Database;

class Checkout extends BaseController
{
    protected CartItemModel $cartModel;
    protected ProductModel $productModel;
    protected OrderModel $orderModel;
    protected OrderItemModel $orderItemModel;
    protected UserModel $userModel;

    public function __construct()
    {
        $this->cartModel      = new CartItemModel();
        $this->productModel   = new ProductModel();
        $this->orderModel     = new OrderModel();
        $this->orderItemModel = new OrderItemModel();
        $this->userModel      = new UserModel();
    }

    /**
     * Halaman Formulir Checkout
     */
    public function index()
    {
        $userId    = (int) session()->get('user_id');
        $cartItems = $this->cartModel->getUserCart($userId);

        if (empty($cartItems)) {
            return redirect()->to(base_url('keranjang'))->with('error', 'Keranjang belanja Anda masih kosong.');
        }

        // Hitung ulang total
        $subtotal = 0;
        foreach ($cartItems as $item) {
            $subtotal += ($item['price'] * $item['quantity']);
        }
        $shippingCost = OrderModel::calculateShippingCost((float) $subtotal);
        $total        = $subtotal + $shippingCost;

        // Ambil data profil user untuk prefill form
        $user = $this->userModel->find($userId);

        $data = [
            'title'        => 'Checkout Pesanan',
            'cartItems'    => $cartItems,
            'subtotal'     => $subtotal,
            'shippingCost' => $shippingCost,
            'total'        => $total,
            'user'         => $user,
        ];

        return view('checkout/index', $data);
    }

    /**
     * Proses Checkout dengan Database Transaction
     */
    public function process()
    {
        $userId = (int) session()->get('user_id');

        $rules = [
            'recipient_name' => [
                'label' => 'Nama Penerima',
                'rules' => 'required|min_length[3]|max_length[100]',
                'errors' => [
                    'required'   => '{field} wajib diisi.',
                    'min_length' => '{field} minimal 3 karakter.',
                ],
            ],
            'phone' => [
                'label' => 'Nomor Telepon',
                'rules' => 'required|numeric|min_length[10]|max_length[15]',
                'errors' => [
                    'required'   => '{field} wajib diisi.',
                    'numeric'    => '{field} harus berupa angka.',
                    'min_length' => '{field} minimal 10 digit.',
                    'max_length' => '{field} maksimal 15 digit.',
                ],
            ],
            'address' => [
                'label' => 'Alamat Lengkap',
                'rules' => 'required|min_length[10]',
                'errors' => [
                    'required'   => '{field} wajib diisi.',
                    'min_length' => '{field} minimal 10 karakter.',
                ],
            ],
            'city' => [
                'label' => 'Kota / Kabupaten',
                'rules' => 'required|max_length[80]',
                'errors' => [
                    'required' => '{field} wajib diisi.',
                ],
            ],
            'postal_code' => [
                'label' => 'Kode Pos',
                'rules' => 'required|numeric|exact_length[5]',
                'errors' => [
                    'required'     => '{field} wajib diisi.',
                    'numeric'      => '{field} harus berupa 5 digit angka.',
                    'exact_length' => '{field} harus tepat 5 digit angka.',
                ],
            ],
            'payment_method' => [
                'label' => 'Metode Pembayaran',
                'rules' => 'required|in_list[transfer,cod]',
                'errors' => [
                    'required' => '{field} wajib dipilih.',
                    'in_list'  => 'Metode pembayaran tidak valid.',
                ],
            ],
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        // Ambil item keranjang langsung dari database
        $cartItems = $this->cartModel->where('user_id', $userId)->findAll();
        if (empty($cartItems)) {
            return redirect()->to(base_url('keranjang'))->with('error', 'Keranjang belanja Anda kosong.');
        }

        $db = Database::connect();
        $db->transBegin();

        try {
            $subtotal   = 0;
            $orderItems = [];

            // Validasi stok dan ambil snapshot data harga asli
            foreach ($cartItems as $item) {
                // Lock row produk untuk konsistensi stok
                $product = $this->productModel->find($item['product_id']);

                if (!$product || !$product['is_active']) {
                    throw new \Exception('Produk "' . ($product['name'] ?? 'ID ' . $item['product_id']) . '" tidak tersedia lagi.');
                }

                if ($product['stock'] < $item['quantity']) {
                    throw new \Exception('Stok untuk mainan "' . $product['name'] . '" tidak mencukupi (tersisa ' . $product['stock'] . ' unit).');
                }

                $itemSubtotal = $product['price'] * $item['quantity'];
                $subtotal    += $itemSubtotal;

                $orderItems[] = [
                    'product_id'   => $product['id'],
                    'product_name' => $product['name'], // Snapshot nama
                    'price'        => $product['price'], // Snapshot harga
                    'quantity'     => $item['quantity'],
                    'subtotal'     => $itemSubtotal,
                ];

                // Kurangi stok produk
                $newStock = $product['stock'] - $item['quantity'];
                $this->productModel->update($product['id'], ['stock' => $newStock]);
            }

            $shippingCost = OrderModel::calculateShippingCost((float) $subtotal);
            $total        = $subtotal + $shippingCost;
            $orderCode    = OrderModel::generateOrderCode();

            // Buat baris pesanan utama
            $orderData = [
                'order_code'     => $orderCode,
                'user_id'        => $userId,
                'recipient_name' => $this->request->getPost('recipient_name'),
                'phone'          => $this->request->getPost('phone'),
                'address'        => $this->request->getPost('address'),
                'city'           => $this->request->getPost('city'),
                'postal_code'    => $this->request->getPost('postal_code'),
                'note'           => $this->request->getPost('note'),
                'payment_method' => $this->request->getPost('payment_method'),
                'subtotal'       => $subtotal,
                'shipping_cost'  => $shippingCost,
                'total'          => $total,
                'status'         => 'pending',
            ];

            $orderId = $this->orderModel->insert($orderData);

            // Simpan semua item pesanan
            foreach ($orderItems as &$oi) {
                $oi['order_id'] = $orderId;
            }
            $this->orderItemModel->insertBatch($orderItems);

            // Kosongkan keranjang belanja
            $this->cartModel->where('user_id', $userId)->delete();

            if ($db->transStatus() === false) {
                $db->transRollback();
                return redirect()->back()->withInput()->with('error', 'Terjadi kesalahan sistem saat memproses pesanan. Silakan coba lagi.');
            }

            $db->transCommit();

            return redirect()->to(base_url('pesanan/sukses/' . $orderCode))->with('success', 'Pesanan Anda berhasil dibuat!');
        } catch (\Exception $e) {
            $db->transRollback();
            return redirect()->back()->withInput()->with('error', $e->getMessage());
        }
    }
}

