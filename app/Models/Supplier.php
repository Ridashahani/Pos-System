<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Supplier extends Model
{
     use HasFactory;

    protected $fillable = ['name', 'phone', 'address'];

    public function purchases()
    {
        return $this->hasMany(Purchase::class);
    }

    // System-calculated, read-only — total due amount across all purchases
    public function getBalanceAttribute(): float
    {
        return $this->purchases->sum(function ($purchase) {
            return $purchase->total_amount - $purchase->amount_paid;
        });
    }
}
