@extends('layouts.app')
@section('content')
    <div class="p-6" x-data="purchaseForm()">
        <div class="max-w-4xl mx-auto bg-white rounded-xl shadow-sm p-6">
            <div class="flex justify-between items-center mb-6">
                <div class="flex items-center gap-3">
                    <span class="bg-blue-100 text-blue-500 p-2 rounded-lg">⬇️</span>
                    <div>
                        <p class="text-xs text-blue-500 font-semibold">NEW RECORD</p>
                        <h2 class="text-lg font-semibold">Add — Purchase</h2>
                    </div>
                </div>
                <a href="{{ route('purchases.index') }}" class="text-sm border px-3 py-1.5 rounded-lg">← Back</a>
            </div>

            <form action="{{ route('purchases.store') }}" method="POST">
                @csrf

                <div class="grid grid-cols-2 gap-4 mb-4">
                    <div>
                        <label class="text-sm text-gray-600">Supplier</label>
                        <select name="supplier_id" class="w-full border rounded-lg px-3 py-2 text-sm mt-1">
                            <option value="">New Supplier </option>
                            <option value="1">Al-Karam Mobile Traders</option>
                            <option value="2">Rehman Accessories Wholesale</option>
                            <option value="3">Global Gadget Importers</option>
                        </select>
                    </div>
                    <div>
                        <label class="text-sm text-gray-600">Receiving Branch</label>
                        <select name="branch_id" class="w-full border rounded-lg px-3 py-2 text-sm mt-1">
                            <option value="1">Saddar Main Branch</option>
                            <option value="2">Commercial Market Branch</option>
                        </select>
                    </div>
                </div>

                <div class="bg-gray-50 rounded-lg p-4 mb-4">
                    <p class="text-sm font-medium mb-2">New Supplier Details</p>
                    <div class="grid grid-cols-3 gap-3">
                        <input type="text" name="new_supplier_name" placeholder="Supplier Name"
                            class="border rounded-lg px-3 py-2 text-sm">
                        <input type="text" name="new_supplier_phone" placeholder="Phone"
                            class="border rounded-lg px-3 py-2 text-sm">
                        <input type="text" name="new_supplier_address" placeholder="Address"
                            class="border rounded-lg px-3 py-2 text-sm">
                    </div>
                    <p class="text-xs text-gray-400 mt-1">These details will be saved when you click the main save button.
                    </p>
                </div>

                <div class="grid grid-cols-2 gap-4 mb-4">
                    <div>
                        <label class="text-sm text-gray-600">Date</label>
                        <input type="date" name="date" value="{{ now()->format('Y-m-d') }}"
                            class="w-full border rounded-lg px-3 py-2 text-sm mt-1">
                    </div>
                    <div>
                        <label class="text-sm text-gray-600">Payment Status</label>
                        <select name="payment_status" class="w-full border rounded-lg px-3 py-2 text-sm mt-1">
                            <option value="paid">Paid</option>
                            <option value="partial">Partial</option>
                            <option value="due">Due</option>
                        </select>
                    </div>
                </div>

                <div class="mb-6">
                    <label class="text-sm text-gray-600">Amount Paid (Rs)</label>
                    <input type="number" name="amount_paid" value="0"
                        class="w-full border rounded-lg px-3 py-2 text-sm mt-1">
                </div>

                <div class="mb-3 flex justify-between items-center">
                    <div>
                        <p class="text-xs text-blue-500 font-semibold">PRODUCTS IN THIS PURCHASE</p>
                        <p class="text-sm font-medium">Add one or more products</p>
                        <p class="text-xs text-gray-400">Use + Add Product for another line and × to remove one — each line
                            updates that product's stock.</p>
                    </div>
                    <button type="button" @click="addProduct()"
                        class="bg-blue-500 text-white text-sm px-3 py-1.5 rounded-lg">+ Add Product</button>
                </div>

                <template x-for="(row, index) in products" :key="index">
                    <div class="border rounded-lg p-4 mb-3">
                        <div class="flex justify-between mb-2">
                            <p class="text-sm font-medium">Product <span x-text="index + 1"></span></p>
                            <button type="button" @click="removeProduct(index)" x-show="products.length > 1"
                                class="text-red-400 text-sm">×</button>
                        </div>
                        <div class="grid grid-cols-3 gap-3">
                            <select :name="`products[${index}][product_id]`" class="border rounded-lg px-3 py-2 text-sm">
                                <option value="1">Samsung Galaxy A15 · Rs 38000</option>
                                <option value="2">Fast Charger 20W · Rs 650</option>
                                <option value="3">Wireless Earbuds X200 · Rs 1800</option>
                            </select>
                            <input type="number" :name="`products[${index}][quantity]`" x-model="row.quantity"
                                placeholder="Quantity" class="border rounded-lg px-3 py-2 text-sm">
                            <input type="number" :name="`products[${index}][cost_price]`" x-model="row.cost_price"
                                placeholder="Cost Price / Unit (Rs)" class="border rounded-lg px-3 py-2 text-sm">
                        </div>
                    </div>
                </template>

                <div class="flex justify-end gap-3 mt-6">
                    <a href="{{ route('purchases.index') }}" class="border px-4 py-2 rounded-lg text-sm">Cancel</a>
                    <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded-lg text-sm">Save
                        Purchase</button>
                </div>
            </form>
        </div>
    </div>

    <script>
        function purchaseForm() {
            return {
                products: [{
                    quantity: 1,
                    cost_price: 0
                }],
                addProduct() {
                    this.products.push({
                        quantity: 1,
                        cost_price: 0
                    });
                },
                removeProduct(index) {
                    this.products.splice(index, 1);
                }
            }
        }
    </script>
@endsection
