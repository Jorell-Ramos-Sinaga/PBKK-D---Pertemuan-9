<?php

namespace App\Controllers;

use App\Models\OrderItemModel;
use App\Models\OrderModel;
use App\Models\ProductModel;
use CodeIgniter\Exceptions\PageNotFoundException;
use Config\Database;

class Orders extends BaseController
{
    protected OrderModel $orderModel;
    protected OrderItemModel $orderItemModel;
    protected ProductModel $productModel;

    public function __construct()
    {
        $this->orderModel     = new OrderModel();
        $this->orderItemModel = new OrderItemModel();
        $this->productModel   = new ProductModel();
    }

    /**
     * Riwayat Pesanan Milik Pelanggan
     */
    public function index()
    {
        $userId = (int) session()->get('user_id');
        $orders = $this->orderModel->where('user_id', $userId)->orderBy('id', 'DESC')->findAll();

        $data = [
            'title'  => 'Pesanan Saya',
            'orders' => $orders,
        ];

        return view('orders/index', $data);
    }

    /**
     * Detail Pesanan Pelanggan
     */
    public function detail(string $orderCode)
    {
        $userId = (int) session()->get('user_id');
        $order  = $this->orderModel->where('order_code', $orderCode)
            ->where('user_id', $userId)
            ->first();

        if (!$order) {
            throw PageNotFoundException::forPageNotFound('Pesanan tidak ditemukan: ' . esc($orderCode));
        }

        $items = $this->orderItemModel->getOrderItems((int) $order['id']);

        $data = [
            'title' => 'Detail Pesanan ' . $order['order_code'],
            'order' => $order,
            'items' => $items,
        ];

        return view('orders/detail', $data);
    }

    /**
     * Cetak / Unduh Invoice Pesanan Pelanggan
     */
    public function invoice(string $orderCode)
    {
        $userId = (int) session()->get('user_id');
        $order  = $this->orderModel->where('order_code', $orderCode)
            ->where('user_id', $userId)
            ->first();

        if (!$order) {
            throw PageNotFoundException::forPageNotFound('Invoice tidak ditemukan: ' . esc($orderCode));
        }

        $items = $this->orderItemModel->getOrderItems((int) $order['id']);

        $data = [
            'title' => 'Invoice ' . $order['order_code'],
            'order' => $order,
            'items' => $items,
        ];

        return view('orders/invoice', $data);
    }

    /**
     * Pembatalan Pesanan oleh Pelanggan (Hanya jika status 'pending')
     */
    public function cancel(string $orderCode)
    {
        $userId = (int) session()->get('user_id');
        $order  = $this->orderModel->where('order_code', $orderCode)
            ->where('user_id', $userId)
            ->first();

        if (!$order) {
            return redirect()->to(base_url('pesanan'))->with('error', 'Pesanan tidak ditemukan.');
        }

        if ($order['status'] !== 'pending') {
            return redirect()->back()->with('error', 'Pesanan tidak dapat dibatalkan karena sudah dalam proses pengiriman atau sudah selesai.');
        }

        $db = Database::connect();
        $db->transBegin();

        try {
            // Ubah status ke cancelled
            $this->orderModel->update($order['id'], ['status' => 'cancelled']);

            // Kembalikan stok produk
            $items = $this->orderItemModel->where('order_id', $order['id'])->findAll();
            foreach ($items as $item) {
                if (!empty($item['product_id'])) {
                    $product = $this->productModel->find($item['product_id']);
                    if ($product) {
                        $this->productModel->update($item['product_id'], [
                            'stock' => $product['stock'] + $item['quantity'],
                        ]);
                    }
                }
            }

            if ($db->transStatus() === false) {
                $db->transRollback();
                return redirect()->back()->with('error', 'Gagal membatalkan pesanan. Silakan coba lagi.');
            }

            $db->transCommit();
            return redirect()->back()->with('success', 'Pesanan berhasil dibatalkan dan stok produk telah dikembalikan.');
        } catch (\Exception $e) {
            $db->transRollback();
            return redirect()->back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    /**
     * Halaman Sukses Setelah Checkout
     */
    public function success(string $orderCode)
    {
        $userId = (int) session()->get('user_id');
        $order  = $this->orderModel->where('order_code', $orderCode)
            ->where('user_id', $userId)
            ->first();

        if (!$order) {
            return redirect()->to(base_url('pesanan'));
        }

        $items = $this->orderItemModel->getOrderItems((int) $order['id']);

        $data = [
            'title' => 'Pesanan Berhasil Dibuat',
            'order' => $order,
            'items' => $items,
        ];

        return view('orders/success', $data);
    }
}

