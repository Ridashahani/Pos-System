<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;

class PurchaseController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $purchases = collect([
            (object)[
                'date' => Carbon::parse('2026-08-20'),
                'supplier' => (object)['name' => 'Al-Karam Mobile Traders'],
                'branch' => (object)['name' => 'Saddar Main Branch'],
                'items' => collect([
                    (object)['product' => (object)['name' => 'Samsung Galaxy A15'], 'quantity' => 3],
                ]),
                'avg_cost' => 38000,
                'payment_status' => 'partial',
            ],
            (object)[
                'date' => Carbon::parse('2026-08-18'),
                'supplier' => (object)['name' => 'Rehman Accessories Wholesale'],
                'branch' => (object)['name' => 'Saddar Main Branch'],
                'items' => collect([
                    (object)['product' => (object)['name' => 'Fast Charger 20W'], 'quantity' => 40],
                ]),
                'avg_cost' => 650,
                'payment_status' => 'paid',
            ],
            (object)[
                'date' => Carbon::parse('2026-08-27'),
                'supplier' => (object)['name' => 'Global Gadget Importers'],
                'branch' => (object)['name' => 'Commercial Market Branch'],
                'items' => collect([
                    (object)['product' => (object)['name' => 'Wireless Earbuds X200'], 'quantity' => 15],
                ]),
                'avg_cost' => 1800,
                'payment_status' => 'due',
            ],
        ]);

        return view('purchases.index', compact('purchases'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('purchases.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
