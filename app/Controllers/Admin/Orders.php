<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
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
     * Daftar Pesanan Pelanggan untuk Admin
     */
    public function index()
    {
        $statusFilter = $this->request->getGet('status');

        $builder = $this->orderModel->select('orders.*, users.email as user_email')
            ->join('users', 'users.id = orders.user_id', 'left');

        if (!empty($statusFilter) && $statusFilter !== 'all') {
            $builder->where('orders.status', $statusFilter);
        }

        $orders = $builder->orderBy('orders.id', 'DESC')->paginate(15, 'admin_orders');
        $pager  = $this->orderModel->pager;

        $data = [
            'title'        => 'Manajemen Pesanan Masuk',
            'orders'       => $orders,
            'pager'        => $pager,
            'statusFilter' => $statusFilter,
        ];

        return view('admin/orders/index', $data);
    }

    /**
     * Detail Pesanan Admin
     */
    public function detail(int $id)
    {
        $order = $this->orderModel->select('orders.*, users.email as user_email')
            ->join('users', 'users.id = orders.user_id', 'left')
            ->where('orders.id', $id)
            ->first();

        if (!$order) {
            throw PageNotFoundException::forPageNotFound('Pesanan tidak ditemukan.');
        }

        $items = $this->orderItemModel->getOrderItems($id);

        $data = [
            'title' => 'Detail Pesanan #' . $order['order_code'],
            'order' => $order,
            'items' => $items,
        ];

        return view('admin/orders/detail', $data);
    }

    /**
     * Cetak Invoice Pesanan untuk Admin
     */
    public function invoice(int $id)
    {
        $order = $this->orderModel->select('orders.*, users.email as user_email')
            ->join('users', 'users.id = orders.user_id', 'left')
            ->where('orders.id', $id)
            ->first();

        if (!$order) {
            throw PageNotFoundException::forPageNotFound('Invoice tidak ditemukan.');
        }

        $items = $this->orderItemModel->getOrderItems($id);

        $data = [
            'title' => 'Invoice ' . $order['order_code'],
            'order' => $order,
            'items' => $items,
        ];

        return view('orders/invoice', $data);
    }

    /**
     * Perbarui Status Pesanan & Kembalikan Stok jika Dibatalkan
     */
    public function updateStatus(int $id)
    {
        $order = $this->orderModel->find($id);
        if (!$order) {
            return redirect()->to(base_url('admin/pesanan'))->with('error', 'Pesanan tidak ditemukan.');
        }

        $newStatus = $this->request->getPost('status');
        $allowedStatuses = ['pending', 'paid', 'processing', 'shipped', 'completed', 'cancelled'];

        if (!in_array($newStatus, $allowedStatuses, true)) {
            return redirect()->back()->with('error', 'Status pesanan tidak valid.');
        }

        $db = Database::connect();
        $db->transBegin();

        try {
            $oldStatus = $order['status'];

            // Jika status berubah menjadi CANCELLED dan sebelumnya bukan CANCELLED -> Kembalikan stok produk
            if ($newStatus === 'cancelled' && $oldStatus !== 'cancelled') {
                $items = $this->orderItemModel->where('order_id', $id)->findAll();
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
            }

            // Update status pesanan
            $this->orderModel->update($id, ['status' => $newStatus]);

            if ($db->transStatus() === false) {
                $db->transRollback();
                return redirect()->back()->with('error', 'Gagal memperbarui status pesanan.');
            }

            $db->transCommit();

            return redirect()->to(base_url('admin/pesanan/' . $id))->with('success', 'Status pesanan berhasil diperbarui menjadi: ' . strtoupper($newStatus));
        } catch (\Exception $e) {
            $db->transRollback();
            return redirect()->back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }
}

