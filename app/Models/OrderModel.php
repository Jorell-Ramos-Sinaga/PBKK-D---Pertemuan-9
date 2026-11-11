<?php

namespace App\Models;

use CodeIgniter\Model;

class OrderModel extends Model
{
    public const DEFAULT_SHIPPING_COST = 15000;
    public const FREE_SHIPPING_THRESHOLD = 500000;

    protected $table            = 'orders';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = [
        'order_code',
        'user_id',
        'recipient_name',
        'phone',
        'address',
        'city',
        'postal_code',
        'note',
        'payment_method',
        'subtotal',
        'shipping_cost',
        'total',
        'status',
    ];

    // Dates
    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';

    /**
     * Hitung ongkir berdasarkan subtotal
     */
    public static function calculateShippingCost(float $subtotal): float
    {
        return ($subtotal >= self::FREE_SHIPPING_THRESHOLD) ? 0 : self::DEFAULT_SHIPPING_COST;
    }

    /**
     * Menghasilkan kode pesanan unik (contoh: TT-20261111-9A3F)
     */
    public static function generateOrderCode(): string
    {
        return 'TT-' . date('Ymd') . '-' . strtoupper(substr(bin2hex(random_bytes(2)), 0, 4));
    }
}

