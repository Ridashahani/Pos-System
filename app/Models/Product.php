<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'type', 'vendor_id', 'category_id', 'subcategory_id',
        'quantity', 'total_purchase_amount',
    ];

    public function vendor()      { return $this->belongsTo(Vendor::class); }
    public function category()    { return $this->belongsTo(Category::class); }
    public function subcategory() { return $this->belongsTo(Subcategory::class); }
    public function items()       { return $this->hasMany(ProductItem::class); }
}
