<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

    {{-- LEFT: Products table --}}
    <div class="lg:col-span-2 bg-white rounded-xl shadow-sm p-4">
        <table class="w-full text-sm">
            <thead class="text-gray-500 text-left">
                <tr>
                    <th class="py-2">#</th>
                    <th class="py-2">Product</th>
                    <th class="py-2">Quantity</th>
                    <th class="py-2">Cost Price</th>
                    <th class="py-2">Amount</th>
                    <th class="py-2"></th>
                </tr>
            </thead>
            <tbody>
                <template x-for="(row, index) in products" :key="row.id">
                    <tr class="border-t">
                        <td class="py-2" x-text="index + 1"></td>
                        <td class="py-2">
                            <select :name="'products['+index+'][product_id]'" x-model="row.product_id"
                                class="border border-gray-300 rounded-lg px-2 py-1.5 w-full text-sm">
                                <option value="">Select Product</option>
                                @foreach ($products as $product)
                                    <option value="{{ $product->id }}">{{ $product->name }}</option>
                                @endforeach
                            </select>
                        </td>
                        <td class="py-2">
                            <input type="number" :name="'products['+index+'][quantity]'" x-model.number="row.quantity"
                                min="1" class="border border-gray-300 rounded-lg px-2 py-1.5 w-20 text-sm">
                        </td>
                        <td class="py-2">
                            <input type="number" :name="'products['+index+'][cost_price]'" x-model.number="row.cost_price"
                                min="0" class="border border-gray-300 rounded-lg px-2 py-1.5 w-28 text-sm">
                        </td>
                        <td class="py-2" x-text="(row.quantity * row.cost_price || 0).toFixed(2)"></td>
                        <td class="py-2 text-right">
                            <button type="button" @click="removeProduct(index)" class="text-red-400 hover:text-red-600">✕</button>
                        </td>
                    </tr>
                </template>
            </tbody>
        </table>

        <button type="button" @click="addProduct()"
            class="mt-4 w-full border-2 border-dashed border-gray-300 rounded-lg py-2 text-sm text-gray-600 hover:bg-gray-50">
            + Add Product
        </button>
    </div>

    {{-- RIGHT: Supplier, Branch, Date, Payment --}}
    <div class="space-y-6">

        <div class="bg-white rounded-xl shadow-sm p-4">
            <label class="text-sm font-medium text-gray-700 flex items-center gap-2 mb-2">
                Supplier *
                <button type="button" @click="isNewSupplier = !isNewSupplier"
                    class="ml-auto w-6 h-6 flex items-center justify-center bg-gray-800 text-white rounded-md text-xs">+</button>
            </label>

            <template x-if="!isNewSupplier">
                <select name="supplier_id" class="border border-gray-300 rounded-lg px-3 py-2 w-full text-sm">
                    <option value="">Select a supplier</option>
                    @foreach ($suppliers as $supplier)
                        <option value="{{ $supplier->id }}">{{ $supplier->name }}</option>
                    @endforeach
                </select>
            </template>

            <template x-if="isNewSupplier">
                <div class="space-y-2">
                    <input type="text" name="new_supplier_name" placeholder="Supplier name"
                        class="border border-gray-300 rounded-lg px-3 py-2 w-full text-sm">
                    <input type="text" name="new_supplier_phone" placeholder="Phone"
                        class="border border-gray-300 rounded-lg px-3 py-2 w-full text-sm">
                    <input type="text" name="new_supplier_address" placeholder="Address"
                        class="border border-gray-300 rounded-lg px-3 py-2 w-full text-sm">
                </div>
            </template>

            <label class="text-sm font-medium text-gray-700 block mt-4 mb-2">Branch *</label>
            <select name="branch_id" class="border border-gray-300 rounded-lg px-3 py-2 w-full text-sm">
                <option value="">Select a branch</option>
                @foreach ($branches as $branch)
                    <option value="{{ $branch->id }}">{{ $branch->name }}</option>
                @endforeach
            </select>

            <label class="text-sm font-medium text-gray-700 block mt-4 mb-2">Date *</label>
            <input type="date" name="date" value="{{ date('Y-m-d') }}"
                class="border border-gray-300 rounded-lg px-3 py-2 w-full text-sm">
        </div>

        <div class="bg-white rounded-xl shadow-sm p-4">
            <h3 class="font-semibold text-gray-800 mb-3">Payment Summary</h3>

            <div class="flex justify-between text-sm mb-2">
                <span class="text-gray-500">Total amount</span>
                <span x-text="totalAmount().toFixed(2)"></span>
            </div>

            <label class="text-sm font-medium text-gray-700 block mt-3 mb-1">Payment Status *</label>
            <select name="payment_status" class="border border-gray-300 rounded-lg px-3 py-2 w-full text-sm">
                <option value="paid">Paid</option>
                <option value="partial">Partial</option>
                <option value="due">Due</option>
            </select>

            <label class="text-sm font-medium text-gray-700 block mt-3 mb-1">Amount Paid</label>
            <input type="number" name="amount_paid" x-model.number="amountPaid" min="0"
                class="border border-gray-300 rounded-lg px-3 py-2 w-full text-sm">

            <div class="flex justify-between text-sm mt-3 pt-3 border-t">
                <span class="font-semibold">Due Amount</span>
                <span class="text-red-500 font-semibold" x-text="dueAmount().toFixed(2)"></span>
            </div>
        </div>

        <button type="submit"
            class="w-full bg-blue-500 hover:bg-blue-600 text-white font-medium py-2.5 rounded-lg text-sm">
            Save Purchase
        </button>
    </div>
</div>