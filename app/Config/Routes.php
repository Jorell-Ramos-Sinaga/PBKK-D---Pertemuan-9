<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */

// 1. Rute Publik (Home, Informasi, Produk)
$routes->get('/', 'Home::index');
$routes->get('tentang', 'Home::about');
$routes->get('kontak', 'Home::contact');
$routes->get('produk', 'Products::index');
$routes->get('produk/(:segment)', 'Products::detail/$1');

// 2. Rute Autentikasi
$routes->match(['get', 'post'], 'daftar', 'Auth::register');
$routes->match(['get', 'post'], 'masuk', 'Auth::login');
$routes->get('keluar', 'Auth::logout');

// 3. Rute Wajib Login (Pelanggan)
$routes->group('', ['filter' => 'auth'], static function ($routes) {
    // Keranjang Belanja
    $routes->get('keranjang', 'Cart::index');
    $routes->post('keranjang/tambah', 'Cart::add');
    $routes->post('keranjang/ubah', 'Cart::update');
    $routes->post('keranjang/hapus/(:num)', 'Cart::remove/$1');

    // Checkout
    $routes->get('checkout', 'Checkout::index');
    $routes->post('checkout/proses', 'Checkout::process');

    // Pesanan Pelanggan
    $routes->get('pesanan', 'Orders::index');
    $routes->get('pesanan/(:segment)', 'Orders::detail/$1');
    $routes->get('pesanan/invoice/(:segment)', 'Orders::invoice/$1');
    $routes->post('pesanan/batal/(:segment)', 'Orders::cancel/$1');
    $routes->get('pesanan/sukses/(:segment)', 'Orders::success/$1');

    // Profil Pengguna
    $routes->get('profil', 'Profile::index');
    $routes->post('profil', 'Profile::update');
    $routes->post('profil/password', 'Profile::changePassword');
});

// 4. Rute Admin (Wajib Login & Role Admin)
$routes->group('admin', ['filter' => ['auth', 'admin']], static function ($routes) {
    $routes->get('/', 'Admin\Dashboard::index');

    // Kategori
    $routes->get('kategori', 'Admin\Categories::index');
    $routes->get('kategori/baru', 'Admin\Categories::new');
    $routes->post('kategori/simpan', 'Admin\Categories::create');
    $routes->get('kategori/ubah/(:num)', 'Admin\Categories::edit/$1');
    $routes->post('kategori/perbarui/(:num)', 'Admin\Categories::update/$1');
    $routes->post('kategori/hapus/(:num)', 'Admin\Categories::delete/$1');

    // Produk
    $routes->get('produk', 'Admin\Products::index');
    $routes->get('produk/baru', 'Admin\Products::new');
    $routes->post('produk/simpan', 'Admin\Products::create');
    $routes->get('produk/ubah/(:num)', 'Admin\Products::edit/$1');
    $routes->post('produk/perbarui/(:num)', 'Admin\Products::update/$1');
    $routes->post('produk/hapus/(:num)', 'Admin\Products::delete/$1');

    // Pesanan
    $routes->get('pesanan', 'Admin\Orders::index');
    $routes->get('pesanan/(:num)', 'Admin\Orders::detail/$1');
    $routes->get('pesanan/invoice/(:num)', 'Admin\Orders::invoice/$1');
    $routes->post('pesanan/status/(:num)', 'Admin\Orders::updateStatus/$1');

    // Pelanggan
    $routes->get('pelanggan', 'Admin\Customers::index');
});
