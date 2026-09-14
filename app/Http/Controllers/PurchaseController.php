<?php

namespace App\Http\Controllers;

use App\Http\Requests\PurchaseRequest;
use App\Models\Branch;
use App\Models\Product;
use App\Models\Purchase;
use App\Models\Supplier;
use Illuminate\Support\Facades\DB;

class PurchaseController extends Controller
{
    /**
     * Display a listing of purchases.
     */
    public function index()
    {
        $purchases = Purchase::with([
            'supplier',
            'branch',
            // 'items.product'
        ])
            ->latest()
            ->get();

        return view('purchases.index', compact('purchases'));
    }

    /**
     * Show the form for creating a new purchase.
     */
    public function create()
    {
        return view('purchases.create', [
            // 'products' => Product::all(),
            'suppliers' => Supplier::all(),
            'branches' => Branch::all(),
        ]);
    }

    /**
     * Store a newly created purchase.
     */
    public function store(PurchaseRequest $request)
    {
        $validated = $request->validated();

        DB::transaction(function () use ($validated) {

            $supplierId = $validated['supplier_id'] ?? null;

            // If existing supplier is not selected,
            // create a new supplier
            if (!$supplierId) {

                $supplier = Supplier::create([
                    'name' => $validated['new_supplier_name'],
                    'phone' => $validated['new_supplier_phone'] ?? null,
                    'address' => $validated['new_supplier_address'] ?? null,
                ]);

                $supplierId = $supplier->id;
            }
            $purchase = Purchase::create([
                'supplier_id' => $supplierId,
                'branch_id' => $validated['branch_id'],
                'date' => $validated['date'],
                'payment_status' => $validated['payment_status'],
                'amount_paid' => $validated['amount_paid'] ?? 0,
            ]);

            foreach ($validated['products'] as $row) {

                $purchase->items()->create([
                    // 'product_id' => $row['product_id'],
                    'quantity' => $row['quantity'],
                    'cost_price' => $row['cost_price'],
                ]);
            }
        });

        return redirect()
            ->route('purchases.index')
            ->with('success', 'Purchase saved successfully.');
    }

    /**
     * Show the form for editing the specified purchase.
     */
    public function edit(string $id)
    {
        $purchase = Purchase::with('items')
            ->findOrFail($id);

        return view('purchases.edit', [
            'purchase' => $purchase,
            // 'products' => Product::all(),
            'suppliers' => Supplier::all(),
            'branches' => Branch::all(),
        ]);
    }

    /**
     * Update the specified purchase.
     */
    public function update(PurchaseRequest $request, string $id)
    {
        $validated = $request->validated();

        $purchase = Purchase::findOrFail($id);

        DB::transaction(function () use ($validated, $purchase) {

            $supplierId = $validated['supplier_id'] ?? null;
            if (!$supplierId) {

                $supplier = Supplier::create([
                    'name' => $validated['new_supplier_name'],
                    'phone' => $validated['new_supplier_phone'] ?? null,
                    'address' => $validated['new_supplier_address'] ?? null,
                ]);

                $supplierId = $supplier->id;
            }

            $purchase->update([
                'supplier_id' => $supplierId,
                'branch_id' => $validated['branch_id'],
                'date' => $validated['date'],
                'payment_status' => $validated['payment_status'],
                'amount_paid' => $validated['amount_paid'] ?? 0,
            ]);

            $purchase->items()->delete();

            // foreach ($validated['products'] as $row) {

            //     $purchase->items()->create([
            //         'product_id' => $row['product_id'],
            //         'quantity' => $row['quantity'],
            //         'cost_price' => $row['cost_price'],
            //     ]);
            // }
        });

        return redirect()
            ->route('purchases.index')
            ->with('success', 'Purchase updated successfully.');
    }

    /**
     * Remove the specified purchase.
     */
    public function destroy(string $id)
    {
        $purchase = Purchase::findOrFail($id);

        $purchase->delete();

        return redirect()
            ->route('purchases.index')
            ->with('success', 'Purchase deleted.');
    }
}
