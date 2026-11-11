<?php

namespace App\Controllers;

use App\Models\CategoryModel;
use App\Models\ProductModel;

class Home extends BaseController
{
    protected CategoryModel $categoryModel;
    protected ProductModel $productModel;

    public function __construct()
    {
        $this->categoryModel = new CategoryModel();
        $this->productModel  = new ProductModel();
    }

    /**
     * Halaman Beranda (Hero, Kategori, Produk Unggulan, Produk Terbaru, Keunggulan)
     */
    public function index(): string
    {
        $data = [
            'title'            => 'Dunia Mainan Seru Anak & Keluarga',
            'categories'       => $this->categoryModel->orderBy('name', 'ASC')->findAll(),
            'featuredProducts' => $this->productModel->getFeaturedProducts(8),
            'latestProducts'   => $this->productModel->getLatestProducts(8),
        ];

        return view('home/index', $data);
    }

    /**
     * Halaman Tentang Kami
     */
    public function about(): string
    {
        $data = [
            'title' => 'Tentang Kami',
        ];

        return view('home/about', $data);
    }

    /**
     * Halaman Kontak Kami
     */
    public function contact(): string
    {
        $data = [
            'title' => 'Hubungi Kami',
        ];

        return view('home/contact', $data);
    }
}
