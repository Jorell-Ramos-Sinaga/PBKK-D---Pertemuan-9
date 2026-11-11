<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\CategoryModel;
use App\Models\OrderModel;
use App\Models\ProductModel;
use App\Models\UserModel;

class Dashboard extends BaseController
{
    protected ProductModel $productModel;
    protected OrderModel $orderModel;
    protected UserModel $userModel;
    protected CategoryModel $categoryModel;

    public function __construct()
    {
        $this->productModel  = new ProductModel();
        $this->orderModel    = new OrderModel();
        $this->userModel     = new UserModel();
        $this->categoryModel = new CategoryModel();
    }

    /**
     * Halaman Dashboard Utama Admin
     */
    public function index()
    {
        // 1. Statistik Kartu
        $totalProducts = $this->productModel->countAllResults();
        $totalOrders   = $this->orderModel->countAllResults();
        $pendingOrders = $this->orderModel->where('status', 'pending')->countAllResults();
        $customersCount = $this->userModel->where('role', 'customer')->countAllResults();

        // Total Pendapatan dari pesanan yang 'completed'
        $db = \Config\Database::connect();
        $revenueRow = $db->table('orders')
            ->selectSum('total')
            ->where('status', 'completed')
            ->get()
            ->getRow();
        $totalRevenue = (float) ($revenueRow->total ?? 0);

        // 2. 5 Pesanan Terbaru
        $recentOrders = $this->orderModel->orderBy('id', 'DESC')->findAll(5);

        // 3. Produk Stok Menipis (Stok <= 5)
        $lowStockProducts = $this->productModel
            ->select('products.*, categories.name as category_name')
            ->join('categories', 'categories.id = products.category_id', 'left')
            ->where('products.stock <=', 5)
            ->where('products.is_active', 1)
            ->orderBy('products.stock', 'ASC')
            ->findAll(10);

        $data = [
            'title'            => 'Dashboard Administrator',
            'totalProducts'    => $totalProducts,
            'totalOrders'      => $totalOrders,
            'pendingOrders'    => $pendingOrders,
            'totalRevenue'     => $totalRevenue,
            'customersCount'   => $customersCount,
            'recentOrders'     => $recentOrders,
            'lowStockProducts' => $lowStockProducts,
        ];

        return view('admin/dashboard/index', $data);
    }
}

