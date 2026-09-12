@extends('layouts.app')

@section('content')
    <div class="p-6" x-data="purchaseForm()">
        <div class="max-w-7xl mx-auto">

            <div class="flex justify-between items-center mb-6">
                <div>
                    <p class="text-xs text-blue-500 font-semibold uppercase">New Record</p>
                    <h1 class="text-2xl font-semibold text-gray-800">Add — Purchase</h1>
                    <p class="text-sm text-gray-500 mt-1">Create a new purchase from supplier.</p>
                </div>
                <a href="{{ route('purchases.index') }}"
                    class="border border-gray-300 px-4 py-2 rounded-lg text-sm hover:bg-gray-50">← Back</a>
            </div>

            @if ($errors->any())
                <div class="bg-red-50 border border-red-200 text-red-700 text-sm px-4 py-3 rounded-lg mb-4">
                    <ul class="list-disc pl-5">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('purchases.store') }}" method="POST">
                @csrf
                @include('purchases.form', [
                    'products' => $products,
                    'suppliers' => $suppliers,
                    'branches' => $branches,
                ])
            </form>

        </div>
    </div>

    <script>
        function purchaseForm() {
            return {
                products: [{
                    id: Date.now(),
                    product_id: '',
                    quantity: 1,
                    cost_price: 0
                }],
                isNewSupplier: '',
                amountPaid: 0,

                addProduct() {
                    this.products.push({
                        id: Date.now() + Math.random(),
                        product_id: '',
                        quantity: 1,
                        cost_price: 0
                    });
                },
                removeProduct(index) {
                    if (this.products.length > 1) this.products.splice(index, 1);
                },
                totalAmount() {
                    return this.products.reduce((sum, row) => sum + (row.quantity * row.cost_price || 0), 0);
                },
                dueAmount() {
                    return Math.max(this.totalAmount() - Number(this.amountPaid || 0), 0);
                }
            }
        }
    </script>
@endsection
