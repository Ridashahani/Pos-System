@extends('layouts.app')
@php
    $todaySales = 0;
    $todayInvoiceCount = 0;
    $grossProfit = 18038;
    $lowStockCount = 2;
    $activeRepairs = 2;
    $pendingInstalments = 2;
    $offlineQueued = 0;

    $recentSales = collect([
        (object) [
            'invoice_no' => 'INV-1042',
            'customer_name' => 'Walk-in Customer',
            'total' => 473,
            'status' => 'Completed',
        ],
        (object) [
            'invoice_no' => 'INV-1040',
            'customer_name' => 'Usman Farooq',
            'total' => 78000,
            'status' => 'Returned',
        ],
        (object) [
            'invoice_no' => 'INV-1039',
            'customer_name' => 'Ahmed Raza',
            'total' => 2625,
            'status' => 'Completed',
        ],
        (object) [
            'invoice_no' => 'INV-1038',
            'customer_name' => 'Sana Malik',
            'total' => 31500,
            'status' => 'Completed',
        ],
    ]);

    $lowStockItems = collect([
        (object) ['name' => 'Tempered Glass Protector', 'qty' => 8],
        (object) ['name' => 'Power Bank 10000mAh', 'qty' => 4],
    ]);
@endphp

@section('content')
    <h2 class="pt-5 text-2xl font-bold mx-2 mt-[10px] text-[#111827]">Dashboard</h2>
    <p class="text-[#8a8698] text-[13.5px] mb-6 mx-2">Real-time overview of sales, finance, and operations</p>

    {{-- Stat Cards --}}
    <div class="grid grid-cols-4 gap-[18px] mb-7 max-[900px]:grid-cols-2">

        <div
            class="bg-white border border-[#eef0f3] rounded-2xl p-5 shadow-[0_2px_8px_rgba(16,24,40,0.05)] transition-transform duration-150 hover:-translate-y-0.5 hover:shadow-[0_6px_16px_rgba(16,24,40,0.08)]">
            <div
                class="w-10 h-10 rounded-xl flex items-center justify-center text-lg mb-4 bg-gradient-to-br from-[#e3f0ff] to-[#cfe4ff]">
                🛒</div>
            <p class="text-[13px] text-[#6b7280] mb-1.5">Today's Sales</p>
            <h3 class="text-[21px] font-bold text-[#111827] m-0">Rs {{ number_format($todaySales ?? 0) }}</h3>
            <p class="text-[11.5px] text-[#8a8698] m-0">{{ $todayInvoiceCount ?? 0 }} invoice(s)</p>
        </div>

        <div
            class="bg-white border border-[#eef0f3] rounded-2xl p-5 shadow-[0_2px_8px_rgba(16,24,40,0.05)] transition-transform duration-150 hover:-translate-y-0.5 hover:shadow-[0_6px_16px_rgba(16,24,40,0.08)]">
            <div
                class="w-10 h-10 rounded-xl flex items-center justify-center text-lg mb-4 bg-gradient-to-br from-[#e3f9ec] to-[#c9f2d9]">
                📈</div>
            <p class="text-[13px] text-[#6b7280] mb-1.5">Gross Profit (all-time)</p>
            <h3 class="text-[21px] font-bold text-[#111827] m-0">Rs {{ number_format($grossProfit ?? 0) }}</h3>
            <p class="text-[11.5px] text-green-500 m-0">revenue – cost of goods</p>
        </div>

        <div
            class="bg-white border border-[#eef0f3] rounded-2xl p-5 shadow-[0_2px_8px_rgba(16,24,40,0.05)] transition-transform duration-150 hover:-translate-y-0.5 hover:shadow-[0_6px_16px_rgba(16,24,40,0.08)]">
            <div
                class="w-10 h-10 rounded-xl flex items-center justify-center text-lg mb-4 bg-gradient-to-br from-[#ffe1e1] to-[#ffcccc]">
                ⚠️</div>
            <p class="text-[13px] text-[#6b7280] mb-1.5">Low Stock Items</p>
            <h3 class="text-[21px] font-bold text-[#111827] m-0">{{ $lowStockCount ?? 0 }}</h3>
            <p class="text-[11.5px] text-red-500 m-0">at or below reorder level</p>
        </div>

        <div
            class="bg-white border border-[#eef0f3] rounded-2xl p-5 shadow-[0_2px_8px_rgba(16,24,40,0.05)] transition-transform duration-150 hover:-translate-y-0.5 hover:shadow-[0_6px_16px_rgba(16,24,40,0.08)]">
            <div
                class="w-10 h-10 rounded-xl flex items-center justify-center text-lg mb-4 bg-gradient-to-br from-[#ede4ff] to-[#ddd0ff]">
                💳</div>
            <p class="text-[13px] text-[#6b7280] mb-1.5">Instalments Pending</p>
            <h3 class="text-[21px] font-bold text-[#111827] m-0">{{ $pendingInstalments ?? 0 }}</h3>
            <p class="text-[11.5px] text-[#8a8698] m-0">across customers</p>
        </div>

    </div>

    {{-- Panels Row --}}
    <div class="grid grid-cols-[2fr_1fr] gap-5 mb-5 max-[900px]:grid-cols-1">

        {{-- Recent Sales --}}
        <div class="bg-white border border-[#eef0f3] rounded-2xl p-[22px] shadow-[0_1px_3px_rgba(16,24,40,0.04)]">
            <h4 class="text-[15px] font-bold m-0 mb-[18px]">Recent Sales</h4>
            <table class="w-full border-collapse">
                <thead>
                    <tr>
                        <th
                            class="text-left text-[11.5px] uppercase tracking-[0.4px] text-[#8a8698] font-semibold pb-2.5 border-b border-[#edebf3]">
                            Invoice</th>
                        <th
                            class="text-left text-[11.5px] uppercase tracking-[0.4px] text-[#8a8698] font-semibold pb-2.5 border-b border-[#edebf3]">
                            Customer</th>
                        <th
                            class="text-left text-[11.5px] uppercase tracking-[0.4px] text-[#8a8698] font-semibold pb-2.5 border-b border-[#edebf3]">
                            Total</th>
                        <th
                            class="text-left text-[11.5px] uppercase tracking-[0.4px] text-[#8a8698] font-semibold pb-2.5 border-b border-[#edebf3]">
                            Status</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($recentSales as $sale)
                        <tr>
                            <td class="py-3.5 text-[13.5px] border-b border-[#edebf3] text-[#6c63ff] font-semibold">
                                {{ $sale->invoice_no }}</td>
                            <td class="py-3.5 text-[13.5px] border-b border-[#edebf3] font-medium">
                                {{ $sale->customer_name }}</td>
                            <td class="py-3.5 text-[13.5px] border-b border-[#edebf3] font-semibold">Rs
                                {{ number_format($sale->total) }}</td>
                            <td class="py-3.5 text-[13.5px] border-b border-[#edebf3]">
                                @if (strtolower($sale->status) === 'completed')
                                    <span
                                        class="inline-block px-3 py-1 rounded-[20px] text-xs font-semibold bg-[#d1fae5] text-green-700">{{ $sale->status }}</span>
                                @elseif(strtolower($sale->status) === 'returned')
                                    <span
                                        class="inline-block px-3 py-1 rounded-[20px] text-xs font-semibold bg-[#f3f4f6] text-[#8a8698]">{{ $sale->status }}</span>
                                @else
                                    <span
                                        class="inline-block px-3 py-1 rounded-[20px] text-xs font-semibold bg-[#fff1d6] text-orange-600">{{ $sale->status }}</span>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        {{-- Low Stock Alerts --}}
        <div class="bg-white border border-[#eef0f3] rounded-2xl p-[22px] shadow-[0_1px_3px_rgba(16,24,40,0.04)]">
            <h4 class="text-[15px] font-bold m-0 mb-[18px]">Low Stock Alerts</h4>
            <ul class="list-none m-0 p-0">
                @foreach ($lowStockItems as $item)
                    <li
                        class="flex justify-between items-center py-3 border-b border-[#edebf3] text-[13.5px] last:border-b-0">
                        <span>{{ $item->name }}</span>
                        <span class="font-semibold text-red-500 text-[12.5px]">{{ $item->qty }} left</span>
                    </li>
                @endforeach
            </ul>
        </div>

    </div>

    {{-- Charts Row --}}
    <div class="grid grid-cols-[1fr_1.4fr] gap-5 max-[900px]:grid-cols-1">

        {{-- Donut Chart --}}
        <div class="bg-white border border-[#eef0f3] rounded-2xl p-[22px] shadow-[0_2px_8px_rgba(16,24,40,0.05)]">
            <h4 class="m-0 mb-5 text-[15px] font-bold text-[#111827]">Sales (Paid / Due / Return)</h4>
            <div class="w-[200px] h-[200px] rounded-full mx-auto mb-[22px] flex items-center justify-center relative"
                style="background: conic-gradient(#f5b942 0% 49.6%, #4a7dff 49.6% 99.2%, #e05656 99.2% 100%);">
                <div class="absolute w-[130px] h-[130px] bg-white rounded-full"></div>
                <div class="relative z-10 text-center">
                    <p class="text-xs text-[#6b7280] m-0">Paid</p>
                    <h3 class="text-[15px] my-0.5">₨50,938,298</h3>
                    <span class="text-[11.5px] text-[#9ca3af]">49.6%</span>
                </div>
            </div>
            <ul class="list-none flex flex-col gap-2.5 text-[13px] m-0 p-0">
                <li class="flex items-center gap-1.5"><span
                        class="w-2.5 h-2.5 rounded-full bg-[#f5b942] inline-block mr-1.5"></span> Due (₨51,679,876)</li>
                <li class="flex items-center gap-1.5"><span
                        class="w-2.5 h-2.5 rounded-full bg-[#4a7dff] inline-block mr-1.5"></span> Paid (₨50,938,298)</li>
                <li class="flex items-center gap-1.5"><span
                        class="w-2.5 h-2.5 rounded-full bg-[#e05656] inline-block mr-1.5"></span> Return (₨128,762)</li>
            </ul>
        </div>

        {{-- Line Chart Placeholder --}}
        <div class="bg-white border border-[#eef0f3] rounded-2xl p-[22px] shadow-[0_2px_8px_rgba(16,24,40,0.05)]">
            <h4 class="m-0 mb-5 text-[15px] font-bold text-[#111827]">Sales vs Purchases (Monthly)</h4>
            <div class="h-[220px] flex items-center justify-center bg-[#f9fafb] rounded-[10px] text-[#9ca3af]">
                <p class="placeholder-text">Chart area (static)</p>
            </div>
        </div>

    </div>
@endsection
