@extends('layouts.app')

@section('content')

<div class="p-6" x-data="purchaseForm()">

    <div class="max-w-7xl mx-auto">

        {{-- Page Header --}}
        <div class="flex justify-between items-center mb-6">

            <div>
                <p class="text-xs text-blue-500 font-semibold uppercase">
                    New Record
                </p>

                <h1 class="text-2xl font-semibold text-gray-800">
                    Add — Purchase
                </h1>

                <p class="text-sm text-gray-500 mt-1">
                    Create a new purchase from supplier.
                </p>
            </div>

            <a href="{{ route('purchases.index') }}"
               class="border border-gray-300 px-4 py-2 rounded-lg text-sm hover:bg-gray-50">
                ← Back
            </a>

        </div>


        {{-- Main 2 Column Layout --}}
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-5">


            {{-- ================================= --}}
            {{-- LEFT SIDE - PRODUCTS --}}
            {{-- ================================= --}}

            <div class="lg:col-span-2">

                <div class="bg-white rounded-xl shadow-sm border border-gray-100">

                    {{-- Products Header --}}
                    <div class="p-5 border-b">

                        <div class="flex justify-between items-center">

                            <div>
                                <p class="text-xs text-blue-500 font-semibold">
                                    PRODUCTS IN THIS PURCHASE
                                </p>

                                <h2 class="text-lg font-semibold text-gray-800">
                                    Purchase Products
                                </h2>

                                <p class="text-xs text-gray-400 mt-1">
                                    Add one or more products to this purchase.
                                </p>
                            </div>


                            {{-- Add Product --}}
                            <button
                                type="button"
                                @click="addProduct()"
                                class="bg-blue-500 hover:bg-blue-600 text-white text-sm font-medium px-4 py-2 rounded-lg">

                                + Add Product

                            </button>

                        </div>

                    </div>


                    {{-- Product Rows --}}
                    <div class="p-5">

                        <form action="{{ route('purchases.store') }}" method="POST">

                            @csrf


                            <template
                                x-for="(row, index) in products"
                                :key="row.id">

                                <div class="border border-gray-200 rounded-xl p-4 mb-4 bg-gray-50">


                                    {{-- Product Row Header --}}
                                    <div class="flex justify-between items-center mb-4">

                                        <div class="flex items-center gap-2">

                                            <span class="bg-blue-100 text-blue-600 w-7 h-7 rounded-full flex items-center justify-center text-sm font-semibold"
                                                  x-text="index + 1">
                                            </span>

                                            <p class="font-semibold text-gray-700">
                                                Product
                                                <span x-text="index + 1"></span>
                                            </p>

                                        </div>


                                        {{-- Remove --}}
                                        <button
                                            type="button"
                                            @click="removeProduct(index)"
                                            x-show="products.length > 1"
                                            class="w-8 h-8 border border-red-200 rounded-lg text-red-500 hover:bg-red-50">

                                            ×

                                        </button>

                                    </div>


                                    {{-- Product Fields --}}
                                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">


                                        {{-- Product --}}
                                        <div>

                                            <label class="block text-sm font-medium text-gray-600 mb-1">
                                                Product
                                            </label>

                                            <select
                                                :name="`products[${index}][product_id]`"
                                                class="w-full border border-gray-300 rounded-lg px-3 py-2.5 text-sm bg-white focus:outline-none focus:ring-2 focus:ring-blue-400">

                                                <option value="1">
                                                    Samsung Galaxy A15 · Rs 38000
                                                </option>

                                                <option value="2">
                                                    Fast Charger 20W · Rs 650
                                                </option>

                                                <option value="3">
                                                    Wireless Earbuds X200 · Rs 1800
                                                </option>

                                            </select>

                                        </div>


                                        {{-- Quantity --}}
                                        <div>

                                            <label class="block text-sm font-medium text-gray-600 mb-1">
                                                Quantity
                                            </label>

                                            <input
                                                type="number"
                                                min="1"
                                                :name="`products[${index}][quantity]`"
                                                x-model="row.quantity"
                                                class="w-full border border-gray-300 rounded-lg px-3 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-400">

                                        </div>


                                        {{-- Cost Price --}}
                                        <div>

                                            <label class="block text-sm font-medium text-gray-600 mb-1">
                                                Cost Price / Unit (Rs)
                                            </label>

                                            <input
                                                type="number"
                                                min="0"
                                                :name="`products[${index}][cost_price]`"
                                                x-model="row.cost_price"
                                                class="w-full border border-gray-300 rounded-lg px-3 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-400">

                                        </div>

                                    </div>

                                </div>

                            </template>


                            {{-- Add Product Bottom Button --}}
                            <div class="flex justify-center mt-2">

                                <button
                                    type="button"
                                    @click="addProduct()"
                                    class="border border-gray-300 hover:bg-gray-50 px-8 py-2.5 rounded-lg text-sm font-medium text-gray-700">

                                    + &nbsp; Add Product

                                </button>

                            </div>


                            {{-- Buttons --}}
                            <div class="flex justify-end gap-3 mt-6 pt-5 border-t">

                                <a href="{{ route('purchases.index') }}"
                                   class="border border-gray-300 px-5 py-2.5 rounded-lg text-sm hover:bg-gray-50">

                                    Cancel

                                </a>

                                <button
                                    type="submit"
                                    class="bg-blue-500 hover:bg-blue-600 text-white px-5 py-2.5 rounded-lg text-sm font-medium">

                                    Save Purchase

                                </button>

                            </div>

                        </form>

                    </div>

                </div>

            </div>



            {{-- ================================= --}}
            {{-- RIGHT SIDE - SUPPLIER --}}
            {{-- ================================= --}}

            <div>

                <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-5">


                    {{-- Supplier Heading --}}
                    <div class="flex items-center gap-2 mb-5">

                        <span class="text-blue-500">
                            👤
                        </span>

                        <h2 class="text-lg font-semibold text-gray-800">
                            Supplier
                        </h2>

                    </div>


                    {{-- Supplier --}}
                    <div class="mb-4">

                        <label class="block text-sm font-medium text-gray-600 mb-1">
                            Supplier
                        </label>

                        <select
                            name="supplier_id"
                            class="w-full border border-gray-300 rounded-lg px-3 py-2.5 text-sm bg-white">

                            <option value="">
                                -- New Supplier --
                            </option>

                            <option value="1">
                                Al-Karam Mobile Traders
                            </option>

                            <option value="2">
                                Rehman Accessories Wholesale
                            </option>

                            <option value="3">
                                Global Gadget Importers
                            </option>

                        </select>

                    </div>


                    {{-- Receiving Branch --}}
                    <div class="mb-5">

                        <label class="block text-sm font-medium text-gray-600 mb-1">
                            Receiving Branch
                        </label>

                        <select
                            name="branch_id"
                            class="w-full border border-gray-300 rounded-lg px-3 py-2.5 text-sm bg-white">

                            <option value="1">
                                Saddar Main Branch
                            </option>

                            <option value="2">
                                Commercial Market Branch
                            </option>

                        </select>

                    </div>


                    {{-- New Supplier --}}
                    <div class="bg-gray-50 border border-gray-200 rounded-lg p-4 mb-5">

                        <p class="text-sm font-semibold text-gray-700 mb-3">
                            New Supplier Details
                        </p>


                        <div class="space-y-3">

                            <input
                                type="text"
                                name="new_supplier_name"
                                placeholder="Supplier Name"
                                class="w-full border border-gray-300 rounded-lg px-3 py-2.5 text-sm">

                            <input
                                type="text"
                                name="new_supplier_phone"
                                placeholder="Phone"
                                class="w-full border border-gray-300 rounded-lg px-3 py-2.5 text-sm">

                            <input
                                type="text"
                                name="new_supplier_address"
                                placeholder="Address"
                                class="w-full border border-gray-300 rounded-lg px-3 py-2.5 text-sm">

                        </div>

                        <p class="text-xs text-gray-400 mt-2">
                            These details will be saved when you click the main save button.
                        </p>

                    </div>


                    {{-- Date --}}
                    <div class="mb-4">

                        <label class="block text-sm font-medium text-gray-600 mb-1">
                            Date
                        </label>

                        <input
                            type="date"
                            name="date"
                            value="{{ now()->format('Y-m-d') }}"
                            class="w-full border border-gray-300 rounded-lg px-3 py-2.5 text-sm">

                    </div>


                    {{-- Payment Status --}}
                    <div class="mb-4">

                        <label class="block text-sm font-medium text-gray-600 mb-1">
                            Payment Status
                        </label>

                        <select
                            name="payment_status"
                            class="w-full border border-gray-300 rounded-lg px-3 py-2.5 text-sm">

                            <option value="paid">
                                Paid
                            </option>

                            <option value="partial">
                                Partial
                            </option>

                            <option value="due">
                                Due
                            </option>

                        </select>

                    </div>


                    {{-- Amount Paid --}}
                    <div>

                        <label class="block text-sm font-medium text-gray-600 mb-1">
                            Amount Paid (Rs)
                        </label>

                        <input
                            type="number"
                            name="amount_paid"
                            value="0"
                            min="0"
                            class="w-full border border-gray-300 rounded-lg px-3 py-2.5 text-sm">

                    </div>

                </div>

            </div>

        </div>

    </div>


    {{-- Alpine JS --}}
    <script>

        function purchaseForm() {

            return {

                products: [
                    {
                        id: Date.now(),
                        quantity: 1,
                        cost_price: 0
                    }
                ],


                addProduct() {

                    this.products.push({

                        id: Date.now() + Math.random(),

                        quantity: 1,

                        cost_price: 0

                    });

                },


                removeProduct(index) {

                    if (this.products.length > 1) {

                        this.products.splice(index, 1);

                    }

                }

            }

        }

    </script>

@endsection