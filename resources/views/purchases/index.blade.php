@extends('layouts.app')

@section('content')
    <div class="p-6">
        <div class="flex justify-between items-start mb-6">
            <div>
                <h1 class="text-2xl font-semibold text-gray-800">Purchases</h1>
                <p class="text-sm text-gray-500">Purchase order lines received from suppliers, with payment status.</p>
            </div>
        </div>

        @if (session('success'))
            <div class="bg-green-50 border border-green-200 text-green-700 text-sm px-4 py-3 rounded-lg mb-4">
                {{ session('success') }}
            </div>
        @endif

        <div class="flex justify-between items-center mb-4">
            <input type="text" placeholder="Search purchases..."
                class="border border-gray-300 rounded-lg px-4 py-2 w-72 text-sm focus:outline-none focus:ring-2 focus:ring-blue-400">

            <div class="flex items-center gap-3">
                <span class="text-sm text-gray-500">{{ $purchases->count() }} records</span>
                <a href="{{ route('purchases.create') }}"
                    class="bg-blue-500 hover:bg-blue-600 text-white text-sm font-medium px-4 py-2 rounded-lg">
                    + Add Purchase
                </a>
            </div>
        </div>

        <div class="bg-white rounded-xl shadow-sm overflow-hidden">
            <table class="w-full text-sm">
                <thead class="bg-gray-50 text-gray-500 text-left">
                    <tr>
                        <th class="px-4 py-3">Date</th>
                        <th class="px-4 py-3">Supplier</th>
                        <th class="px-4 py-3">Branch</th>
                        <th class="px-4 py-3">Product(s)</th>
                        <th class="px-4 py-3">Total Qty</th>
                        <th class="px-4 py-3">Avg Cost/Unit</th>
                        <th class="px-4 py-3">Payment</th>
                        <th class="px-4 py-3 text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse ($purchases as $purchase)
                        <tr class="hover:bg-gray-50">
                            <td class="px-4 py-3">{{ $purchase->date->format('Y-m-d') }}</td>
                            <td class="px-4 py-3">{{ $purchase->supplier->name ?? '—' }}</td>
                            <td class="px-4 py-3">{{ $purchase->branch->name ?? '—' }}</td>
                            <td class="px-4 py-3">
                                @foreach ($purchase->items as $item)
                                    {{ $item->product->name ?? 'Product' }} x{{ $item->quantity }}@if (!$loop->last)
                                        ,
                                    @endif
                                @endforeach
                            </td>
                            <td class="px-4 py-3">{{ $purchase->total_qty }}</td>
                            <td class="px-4 py-3">Rs {{ number_format($purchase->avg_cost) }}</td>
                            <td class="px-4 py-3">
                                <span @class([
                                    'px-2 py-1 rounded-full text-xs font-medium',
                                    'bg-yellow-100 text-yellow-700' => $purchase->payment_status === 'partial',
                                    'bg-green-100 text-green-700' => $purchase->payment_status === 'paid',
                                    'bg-red-100 text-red-700' => $purchase->payment_status === 'due',
                                ])>
                                    {{ ucfirst($purchase->payment_status) }}
                                </span>
                            </td>
                            <td class="px-4 py-3 text-right">
                                <a href="{{ route('purchases.edit', $purchase->id) }}"
                                    class="text-gray-400 hover:text-blue-500 mr-3"> <i class="fa-solid fa-pen"></i>
                                </a>
                                <form action="{{ route('purchases.destroy', $purchase->id) }}" method="POST"
                                    class="inline" onsubmit="return confirm('Delete this purchase?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-gray-400 hover:text-red-500"> <i
                                            class="fa-solid fa-trash"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="px-4 py-8 text-center text-gray-400">No purchases yet.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    @endsection
