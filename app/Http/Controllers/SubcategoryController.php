<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Subcategory;
use Illuminate\Http\Request;
use App\Http\Requests\StoreSubcategoryRequest;

class SubcategoryController extends Controller
{
    public function index(Request $request)
    {
        $subcategories = Subcategory::with('category')
            ->when($request->search, function ($q, $search) {
                $q->where('name', 'like', "%{$search}%");
            })
            ->latest()
            ->paginate(10)
            ->withQueryString();

        return view('subcategories.index', compact('subcategories'));
    }

    public function create()
    {
        $categories = Category::orderBy('name')->get();
        return view('subcategories.create', compact('categories'));
    }

    public function store(StoreSubcategoryRequest $request)
    {
        Subcategory::create($request->validated());

        return redirect()
            ->route('subcategories.index')
            ->with('success', 'Subcategory created successfully.');
    }

    public function show(Subcategory $subcategory)
    {
        //
    }

    public function edit(Subcategory $subcategory)
    {
        $categories = Category::orderBy('name')->get();
        return view('subcategories.edit', compact('subcategory', 'categories'));
    }

    public function update(StoreSubcategoryRequest $request, Subcategory $subcategory)
    {
        $subcategory->update($request->validated());

        return redirect()->route('subcategories.index')
            ->with('success', 'Subcategory updated successfully.');
    }

    public function destroy(Subcategory $subcategory)
    {
        $subcategory->delete();

        return redirect()->route('subcategories.index')
            ->with('success', 'Subcategory deleted successfully.');
    }
}
