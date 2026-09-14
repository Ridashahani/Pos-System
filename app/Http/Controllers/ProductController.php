<?php

namespace App\Http\Controllers;

use App\Models\Branch;
use App\Models\Category;
use App\Models\Product;
use App\Models\Subcategory;
use App\Models\Vendor;
use Illuminate\Http\Request;
use App\Http\Requests\StoreProductRequest;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $products = Product::with(['vendor', 'category', 'subcategory'])
            ->when($request->search, fn($q, $s) => $q->whereHas('vendor', fn($q) => $q->where('name', 'like', "%{$s}%")))
            ->when($request->type, fn($q, $t) => $q->where('type', $t))
            ->latest()->paginate(10)->withQueryString();

        return view('products.index', compact('products'));
    }

    public function create()
    {
        return view('products.create', $this->formData());
    }

    public function store(StoreProductRequest $request)
    {
        $product = Product::create($request->safe()->except('items'));

        foreach ($request->validated()['items'] as $i => $item) {
            if ($request->hasFile("items.{$i}.image")) {
                $item['image'] = $request->file("items.{$i}.image")->store('products', 'public');
            }
            $product->items()->create($item);
        }

        return redirect()->route('products.index')->with('success', 'Product created successfully.');
    }

    public function edit(Product $product)
    {
        return view('products.edit', array_merge($this->formData(), compact('product')));
    }

    public function update(StoreProductRequest $request, Product $product)
    {
        $product->update($request->safe()->except('items'));

        $product->items()->delete();
        foreach ($request->validated()['items'] as $i => $item) {
            if ($request->hasFile("items.{$i}.image")) {
                $item['image'] = $request->file("items.{$i}.image")->store('products', 'public');
            }
            $product->items()->create($item);
        }

        return redirect()->route('products.index')->with('success', 'Product updated successfully.');
    }

    public function destroy(Product $product)
    {
        $product->delete();
        return redirect()->route('products.index')->with('success', 'Product deleted successfully.');
    }

    private function formData(): array
    {
        return [
            'vendors'       => Vendor::orderBy('name')->get(),
            'categories'    => Category::orderBy('name')->get(),
            'subcategories' => Subcategory::orderBy('name')->get(),
            'branches'      => Branch::orderBy('name')->get(),
        ];
    }
}
