<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductItem extends Model
{
    protected $fillable = [
        'product_id',
        // mobile
        'brand', 'model', 'imei', 'serial_number',
        'warranty_period', 'reg_status', 'branch_id', 'purchase_amount',
        // accessory
        'purchase_price', 'sell_price',
        // shared
        'image',
    ];

    public function product() { return $this->belongsTo(Product::class); }
    public function branch()  { return $this->belongsTo(Branch::class); }
}
