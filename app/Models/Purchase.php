<?php

namespace App\Models;

use App\Models\PurchaseItem;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Purchase extends Model
{
      use HasFactory;
    protected $fillable = [
        'supplier_id',
        'branch_id',
        'date',
        'payment_status',
        'amount_paid',
    ];

    protected $casts = [
        'date' => 'date',
        'amount_paid' => 'decimal:2',
    ];

      public function items()
    {
        return $this->hasMany(PurchaseItem::class);
    }
}
