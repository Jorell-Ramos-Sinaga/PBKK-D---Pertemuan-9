<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\UserModel;

class Customers extends BaseController
{
    protected UserModel $userModel;

    public function __construct()
    {
        $this->userModel = new UserModel();
    }

    /**
     * Daftar Pelanggan Terdaftar
     */
    public function index()
    {
        $db = \Config\Database::connect();
        $customers = $db->table('users')
            ->select('users.*, COUNT(orders.id) as total_orders, COALESCE(SUM(orders.total), 0) as total_spent')
            ->join('orders', 'orders.user_id = users.id', 'left')
            ->where('users.role', 'customer')
            ->groupBy('users.id')
            ->orderBy('users.id', 'DESC')
            ->get()
            ->getResultArray();

        $data = [
            'title'     => 'Daftar Pelanggan',
            'customers' => $customers,
        ];

        return view('admin/customers/index', $data);
    }
}

