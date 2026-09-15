<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class StockController extends Controller
{
    public function index(Request $request)
    {
        $products = Product::with(['vendor', 'category', 'subcategory', 'items.branch'])
            ->when($request->search, function ($query, $search) {
                $query->where(function ($q) use ($search) {
                    $q->where('type', 'like', "%{$search}%")
                        ->orWhereHas('vendor', fn ($vendorQuery) => $vendorQuery->where('name', 'like', "%{$search}%"))
                        ->orWhereHas('category', fn ($categoryQuery) => $categoryQuery->where('name', 'like', "%{$search}%"))
                        ->orWhereHas('subcategory', fn ($subcategoryQuery) => $subcategoryQuery->where('name', 'like', "%{$search}%"));
                });
            })
            ->when($request->type, fn ($query, $type) => $query->where('type', $type))
            ->where('quantity', '>', 0)
            ->latest()
            ->paginate(10)
            ->withQueryString();

        $baseQuery = Product::query()->where('quantity', '>', 0);

        $stats = [
            'total_products' => (clone $baseQuery)->count(),
            'total_units' => (clone $baseQuery)->sum('quantity'),
            'mobile_products' => (clone $baseQuery)->where('type', 'mobile')->count(),
            'accessory_products' => (clone $baseQuery)->where('type', 'accessory')->count(),
            'low_stock' => (clone $baseQuery)->where('quantity', '<=', 5)->count(),
        ];

        return view('stock.stock-in', compact('products', 'stats'));
    }
}
