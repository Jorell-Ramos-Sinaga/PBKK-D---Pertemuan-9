<?php

namespace App\Models;

use CodeIgniter\Model;

class ProductModel extends Model
{
    protected $table            = 'products';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = [
        'category_id',
        'name',
        'slug',
        'description',
        'price',
        'stock',
        'age_range',
        'image',
        'is_featured',
        'is_active',
    ];

    // Dates
    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';

    // Validation
    protected $validationRules = [
        'category_id' => 'required|is_not_unique[categories.id]',
        'name'        => 'required|min_length[3]|max_length[150]',
        'slug'        => 'required|max_length[170]|is_unique[products.slug,id,{id}]',
        'description' => 'required',
        'price'       => 'required|numeric|greater_than[0]',
        'stock'       => 'required|integer|greater_than_equal_to[0]',
    ];

    protected $validationMessages = [
        'category_id' => [
            'required'      => 'Kategori produk wajib dipilih.',
            'is_not_unique' => 'Kategori yang dipilih tidak valid.',
        ],
        'name' => [
            'required'   => 'Nama produk wajib diisi.',
            'min_length' => 'Nama produk minimal 3 karakter.',
            'max_length' => 'Nama produk maksimal 150 karakter.',
        ],
        'slug' => [
            'required'  => 'Slug produk wajib diisi.',
            'is_unique' => 'Slug produk sudah digunakan.',
        ],
        'description' => [
            'required' => 'Deskripsi produk wajib diisi.',
        ],
        'price' => [
            'required'     => 'Harga produk wajib diisi.',
            'numeric'      => 'Harga produk harus berupa angka.',
            'greater_than' => 'Harga produk harus lebih dari 0.',
        ],
        'stock' => [
            'required'              => 'Stok produk wajib diisi.',
            'integer'               => 'Stok produk harus berupa bilangan bulat.',
            'greater_than_equal_to' => 'Stok produk tidak boleh kurang dari 0.',
        ],
    ];

    /**
     * Mengambil produk unggulan untuk beranda
     */
    public function getFeaturedProducts(int $limit = 8): array
    {
        return $this->select('products.*, categories.name as category_name, categories.slug as category_slug')
            ->join('categories', 'categories.id = products.category_id', 'left')
            ->where('products.is_active', 1)
            ->where('products.is_featured', 1)
            ->orderBy('products.id', 'DESC')
            ->findAll($limit);
    }

    /**
     * Mengambil produk terbaru untuk beranda
     */
    public function getLatestProducts(int $limit = 8): array
    {
        return $this->select('products.*, categories.name as category_name, categories.slug as category_slug')
            ->join('categories', 'categories.id = products.category_id', 'left')
            ->where('products.is_active', 1)
            ->orderBy('products.created_at', 'DESC')
            ->findAll($limit);
    }

    /**
     * Mengambil detail produk berdasarkan slug
     */
    public function getProductBySlug(string $slug): ?array
    {
        return $this->select('products.*, categories.name as category_name, categories.slug as category_slug')
            ->join('categories', 'categories.id = products.category_id', 'left')
            ->where('products.slug', $slug)
            ->where('products.is_active', 1)
            ->first();
    }

    /**
     * Mengambil produk terkait dari kategori yang sama
     */
    public function getRelatedProducts(int $categoryId, int $currentProductId, int $limit = 4): array
    {
        return $this->select('products.*, categories.name as category_name')
            ->join('categories', 'categories.id = products.category_id', 'left')
            ->where('products.category_id', $categoryId)
            ->where('products.id !=', $currentProductId)
            ->where('products.is_active', 1)
            ->orderBy('products.id', 'RANDOM')
            ->findAll($limit);
    }
}

