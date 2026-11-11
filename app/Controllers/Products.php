<?php

namespace App\Controllers;

use App\Models\CategoryModel;
use App\Models\ProductModel;
use CodeIgniter\Exceptions\PageNotFoundException;

class Products extends BaseController
{
    protected ProductModel $productModel;
    protected CategoryModel $categoryModel;

    public function __construct()
    {
        $this->productModel  = new ProductModel();
        $this->categoryModel = new CategoryModel();
    }

    /**
     * Katalog Produk dengan Pencarian, Filter Kategori, Filter Harga, Urutkan, & Pagination
     */
    public function index(): string
    {
        $keyword      = trim($this->request->getGet('q') ?? '');
        $categorySlug = trim($this->request->getGet('kategori') ?? '');
        $minPrice     = $this->request->getGet('min');
        $maxPrice     = $this->request->getGet('maks');
        $sortBy       = $this->request->getGet('urut') ?? 'terbaru';

        // Query Builder untuk produk aktif
        $builder = $this->productModel
            ->select('products.*, categories.name as category_name, categories.slug as category_slug')
            ->join('categories', 'categories.id = products.category_id', 'left')
            ->where('products.is_active', 1);

        // Filter Pencarian
        if (!empty($keyword)) {
            $builder->groupStart()
                ->like('products.name', $keyword)
                ->orLike('products.description', $keyword)
                ->groupEnd();
        }

        // Filter Kategori
        $activeCategory = null;
        if (!empty($categorySlug)) {
            $activeCategory = $this->categoryModel->where('slug', $categorySlug)->first();
            if ($activeCategory) {
                $builder->where('products.category_id', $activeCategory['id']);
            }
        }

        // Filter Rentang Harga
        if (is_numeric($minPrice) && (float) $minPrice >= 0) {
            $builder->where('products.price >=', (float) $minPrice);
        }
        if (is_numeric($maxPrice) && (float) $maxPrice > 0) {
            $builder->where('products.price <=', (float) $maxPrice);
        }

        // Pengurutan
        switch ($sortBy) {
            case 'termurah':
                $builder->orderBy('products.price', 'ASC');
                break;
            case 'termahal':
                $builder->orderBy('products.price', 'DESC');
                break;
            case 'nama-asc':
                $builder->orderBy('products.name', 'ASC');
                break;
            case 'terbaru':
            default:
                $builder->orderBy('products.id', 'DESC');
                break;
        }

        // Pagination 12 item per halaman
        $products = $builder->paginate(12, 'products');
        $pager    = $this->productModel->pager;

        $data = [
            'title'          => 'Katalog Produk Mainan',
            'products'       => $products,
            'pager'          => $pager,
            'categories'     => $this->categoryModel->orderBy('name', 'ASC')->findAll(),
            'activeCategory' => $activeCategory,
            'keyword'        => $keyword,
            'categorySlug'   => $categorySlug,
            'minPrice'       => $minPrice,
            'maxPrice'       => $maxPrice,
            'sortBy'         => $sortBy,
            'totalItems'     => $pager->getTotal('products'),
        ];

        return view('products/index', $data);
    }

    /**
     * Halaman Detail Produk
     */
    public function detail(string $slug): string
    {
        $product = $this->productModel->getProductBySlug($slug);

        if (!$product) {
            throw PageNotFoundException::forPageNotFound("Produk tidak ditemukan: " . esc($slug));
        }

        $relatedProducts = $this->productModel->getRelatedProducts((int) $product['category_id'], (int) $product['id'], 4);

        $data = [
            'title'           => $product['name'],
            'product'         => $product,
            'relatedProducts' => $relatedProducts,
        ];

        return view('products/detail', $data);
    }
}

