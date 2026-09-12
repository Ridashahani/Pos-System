<?php

namespace App\Models;

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

    public function supplier()
    {
        return $this->belongsTo(Supplier::class);
    }

    public function branch()
    {
        return $this->belongsTo(Branch::class);
    }

    public function items()
    {
        return $this->hasMany(PurchaseItem::class);
    }

    public function getTotalAmountAttribute(): float
    {
        return $this->items->sum(fn($item) => $item->quantity * $item->cost_price);
    }

    public function getTotalQtyAttribute(): float
    {
        return $this->items->sum('quantity');
    }

    public function getAvgCostAttribute(): float
    {
        return $this->total_qty > 0 ? round($this->total_amount / $this->total_qty) : 0;
    }
}
