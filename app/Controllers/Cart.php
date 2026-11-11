<?php

namespace App\Controllers;

use App\Models\CartItemModel;
use App\Models\OrderModel;
use App\Models\ProductModel;

class Cart extends BaseController
{
    protected CartItemModel $cartModel;
    protected ProductModel $productModel;

    public function __construct()
    {
        $this->cartModel    = new CartItemModel();
        $this->productModel = new ProductModel();
    }

    /**
     * Tampilan Halaman Keranjang Belanja
     */
    public function index()
    {
        $userId    = (int) session()->get('user_id');
        $cartItems = $this->cartModel->getUserCart($userId);

        // Hitung Subtotal
        $subtotal = 0;
        foreach ($cartItems as $item) {
            $subtotal += ($item['price'] * $item['quantity']);
        }

        $shippingCost = OrderModel::calculateShippingCost((float) $subtotal);
        $total        = $subtotal + $shippingCost;

        $data = [
            'title'               => 'Keranjang Belanja',
            'cartItems'           => $cartItems,
            'subtotal'            => $subtotal,
            'shippingCost'        => $shippingCost,
            'total'               => $total,
            'freeShippingMin'     => OrderModel::FREE_SHIPPING_THRESHOLD,
            'defaultShippingCost' => OrderModel::DEFAULT_SHIPPING_COST,
        ];

        return view('cart/index', $data);
    }

    /**
     * Tambah Produk ke Keranjang Belanja
     */
    public function add()
    {
        $userId    = (int) session()->get('user_id');
        $productId = (int) $this->request->getPost('product_id');
        $quantity  = max(1, (int) $this->request->getPost('quantity'));

        $product = $this->productModel->find($productId);

        if (!$product || !$product['is_active']) {
            return redirect()->back()->with('error', 'Produk tidak ditemukan atau sudah tidak aktif.');
        }

        if ($product['stock'] <= 0) {
            return redirect()->back()->with('error', 'Maaf, stok produk ini sedang habis.');
        }

        // Cek apakah produk sudah ada di keranjang user
        $existing = $this->cartModel->where('user_id', $userId)
            ->where('product_id', $productId)
            ->first();

        if ($existing) {
            $newQuantity = $existing['quantity'] + $quantity;
            if ($newQuantity > $product['stock']) {
                $newQuantity = $product['stock'];
                $msg = 'Jumlah produk di keranjang disesuaikan dengan sisa stok maksimal yang tersedia (' . $product['stock'] . ' unit).';
            } else {
                $msg = 'Jumlah produk di keranjang berhasil diperbarui.';
            }

            $this->cartModel->update($existing['id'], ['quantity' => $newQuantity]);

            return redirect()->to(base_url('keranjang'))->with('success', $msg);
        }

        // Jika belum ada, batasi jumlah maksimal tidak melebihi stok
        if ($quantity > $product['stock']) {
            $quantity = $product['stock'];
        }

        $this->cartModel->insert([
            'user_id'    => $userId,
            'product_id' => $productId,
            'quantity'   => $quantity,
        ]);

        return redirect()->to(base_url('keranjang'))->with('success', 'Produk berhasil ditambahkan ke keranjang!');
    }

    /**
     * Ubah Jumlah Item di Keranjang
     */
    public function update()
    {
        $userId   = (int) session()->get('user_id');
        $itemId   = (int) $this->request->getPost('cart_id');
        $quantity = (int) $this->request->getPost('quantity');

        $item = $this->cartModel->where('id', $itemId)->where('user_id', $userId)->first();
        if (!$item) {
            return redirect()->to(base_url('keranjang'))->with('error', 'Item keranjang tidak ditemukan.');
        }

        $product = $this->productModel->find($item['product_id']);
        if (!$product) {
            $this->cartModel->delete($itemId);
            return redirect()->to(base_url('keranjang'))->with('error', 'Produk sudah tidak tersedia.');
        }

        if ($quantity <= 0) {
            $this->cartModel->delete($itemId);
            return redirect()->to(base_url('keranjang'))->with('success', 'Item berhasil dihapus dari keranjang.');
        }

        if ($quantity > $product['stock']) {
            $quantity = $product['stock'];
            $msg = 'Jumlah disesuaikan dengan stok maksimal yang tersedia (' . $product['stock'] . ' unit).';
        } else {
            $msg = 'Keranjang berhasil diperbarui.';
        }

        $this->cartModel->update($itemId, ['quantity' => $quantity]);

        return redirect()->to(base_url('keranjang'))->with('success', $msg);
    }

    /**
     * Hapus Item dari Keranjang
     */
    public function remove(int $id)
    {
        $userId = (int) session()->get('user_id');

        $item = $this->cartModel->where('id', $id)->where('user_id', $userId)->first();
        if ($item) {
            $this->cartModel->delete($id);
            return redirect()->to(base_url('keranjang'))->with('success', 'Item berhasil dihapus dari keranjang.');
        }

        return redirect()->to(base_url('keranjang'))->with('error', 'Item keranjang tidak ditemukan.');
    }
}

