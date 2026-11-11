<?php

namespace App\Models;

use CodeIgniter\Model;

class CartItemModel extends Model
{
    protected $table            = 'cart_items';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ['user_id', 'product_id', 'quantity'];

    // Dates
    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';

    /**
     * Mengambil item keranjang user lengkap dengan detail produk
     */
    public function getUserCart(int $userId): array
    {
        return $this->select('cart_items.*, products.name, products.slug, products.price, products.stock, products.image, products.is_active')
            ->join('products', 'products.id = cart_items.product_id')
            ->where('cart_items.user_id', $userId)
            ->orderBy('cart_items.id', 'DESC')
            ->findAll();
    }
}

