<?php

/**
 * TokoTopia Helper Functions
 * Berisi fungsi bantuan untuk format mata uang, badge status pesanan, gambar produk, dan jumlah keranjang.
 */

if (!function_exists('format_rupiah')) {
    /**
     * Format angka ke Rupiah (contoh: Rp 125.000)
     */
    function format_rupiah($nominal): string
    {
        return 'Rp ' . number_format((float) $nominal, 0, ',', '.');
    }
}

if (!function_exists('cart_count')) {
    /**
     * Menghitung total item di keranjang pengguna yang sedang login
     */
    function cart_count(): int
    {
        $userId = session()->get('user_id');
        if (!$userId) {
            return 0;
        }

        $db = \Config\Database::connect();
        $builder = $db->table('cart_items')->where('user_id', $userId);
        return (int) $builder->selectSum('quantity')->get()->getRow()->quantity ?? 0;
    }
}

if (!function_exists('status_badge')) {
    /**
     * Menghasilkan badge HTML Bootstrap untuk status pesanan
     */
    function status_badge(string $status): string
    {
        $badges = [
            'pending'    => '<span class="badge bg-warning text-dark"><i class="bi bi-clock me-1"></i>Menunggu Pembayaran</span>',
            'paid'       => '<span class="badge bg-info text-dark"><i class="bi bi-wallet2 me-1"></i>Sudah Dibayar</span>',
            'processing' => '<span class="badge bg-primary"><i class="bi bi-box-seam me-1"></i>Diproses</span>',
            'shipped'    => '<span class="badge bg-secondary"><i class="bi bi-truck me-1"></i>Dikirim</span>',
            'completed'  => '<span class="badge bg-success"><i class="bi bi-check-circle me-1"></i>Selesai</span>',
            'cancelled'  => '<span class="badge bg-danger"><i class="bi bi-x-circle me-1"></i>Dibatalkan</span>',
        ];

        return $badges[$status] ?? '<span class="badge bg-light text-dark">' . esc($status) . '</span>';
    }
}

if (!function_exists('product_image')) {
    /**
     * Mengembalikan URL gambar produk atau gambar placeholder jika file tidak ditemukan
     */
    function product_image(?string $image): string
    {
        if ($image && file_exists(FCPATH . 'uploads/products/' . $image)) {
            return base_url('uploads/products/' . $image);
        }
        return base_url('assets/img/placeholder.png');
    }
}

