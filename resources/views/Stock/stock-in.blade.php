@extends('layouts.app')

@section('content')

{{--
    Data contract (pass these from your controller once Inventory is wired up):

    $stats = ['total_items' => 125, 'mobile_units' => 48, 'accessory_items' => 77, 'low_stock' => 8];

    $mobiles = collection of rows, each with:
        model, brand, imei, condition ('New'|'Used'), location, purchase_price, status ('In Stock' etc.)

    $accessories = collection of rows, each with:
        name, sku, category, quantity, reorder_level, location, status ('In Stock'|'Low Stock')

    Until those are passed in, sample rows below are used so the page still renders.
--}}

@php
    $stats = $stats ?? [
        'total_items'     => 125,
        'mobile_units'    => 48,
        'accessory_items' => 77,
        'low_stock'       => 8,
    ];

    $mobiles = $mobiles ?? collect([
        (object) ['model' => 'Samsung Galaxy A15', 'brand' => 'Samsung', 'imei' => '352099123456789', 'condition' => 'New',  'location' => 'Main Shop', 'purchase_price' => '42,000', 'status' => 'In Stock'],
        (object) ['model' => 'iPhone 13',          'brand' => 'Apple',   'imei' => '359876543210123', 'condition' => 'Used', 'location' => 'Main Shop', 'purchase_price' => '78,000', 'status' => 'In Stock'],
        (object) ['model' => 'Vivo Y21',           'brand' => 'Vivo',    'imei' => '861234567890123', 'condition' => 'New',  'location' => 'Branch 1', 'purchase_price' => '31,500', 'status' => 'In Stock'],
    ]);

    $accessories = $accessories ?? collect([
        (object) ['name' => 'Fast Charger 20W (Type-C)', 'sku' => 'ACC-CHG-20W', 'category' => 'Chargers',       'quantity' => 26, 'reorder_level' => 10, 'status' => 'In Stock'],
        (object) ['name' => 'Jazz Prepaid SIM Pack',     'sku' => 'SIM-JAZ-STD', 'category' => 'SIM & Data',      'quantity' => 50, 'reorder_level' => 10, 'status' => 'In Stock'],
        (object) ['name' => 'Power Bank 10000mAh',       'sku' => 'ACC-PWB-10K', 'category' => 'Power Banks',     'quantity' => 4,  'reorder_level' => 6,  'status' => 'Low Stock'],
        (object) ['name' => 'Silicone Case - Generic',   'sku' => 'ACC-CSE-GEN', 'category' => 'Cases & Covers',  'quantity' => 56, 'reorder_level' => 15, 'status' => 'In Stock'],
        (object) ['name' => 'Tempered Glass Protector',  'sku' => 'ACC-TGP-STD', 'category' => 'Screen Protectors','quantity' => 4,  'reorder_level' => 20, 'status' => 'Low Stock'],
        (object) ['name' => 'USB-C Data Cable 1m',       'sku' => 'ACC-CAB-USBC','category' => 'Chargers',       'quantity' => 25, 'reorder_level' => 10, 'status' => 'In Stock'],
        (object) ['name' => 'Wireless Earbuds X200',     'sku' => 'ACC-EAR-X200','category' => 'Earphones',      'quantity' => 15, 'reorder_level' => 8,  'status' => 'In Stock'],
    ]);

    $conditionStyles = [
        'New'  => 'bg-green-50 text-green-700',
        'Used' => 'bg-amber-50 text-amber-700',
    ];

    $statusStyles = [
        'In Stock'  => 'bg-green-50 text-green-700',
        'Low Stock' => 'bg-red-50 text-red-600',
    ];
@endphp

<style>
    /* Stock page: deliberate, consistent spacing so sections never touch. */
    .stock-page {
        width: 100%;
        min-height: calc(100vh - 40px);
        box-sizing: border-box;
        padding: 28px 28px 40px;
        background: #f8fafc;
    }

    .stock-page-inner {
        width: 100%;
        display: flex;
        flex-direction: column;
        gap: 26px;
    }

    .stock-header {
        display: flex;
        align-items: flex-start;
        justify-content: space-between;
        gap: 24px;
        min-height: 54px;
    }

    .stock-header-copy h1 {
        margin: 0;
        line-height: 1.15;
    }

    .stock-header-copy p {
        margin: 8px 0 0;
        line-height: 1.45;
    }

    .stock-actions {
        display: flex;
        align-items: center;
        gap: 10px;
        flex-shrink: 0;
    }

    .stock-summary-grid {
        display: grid;
        grid-template-columns: repeat(4, minmax(0, 1fr));
        gap: 16px;
    }

    .stock-summary-card {
        min-width: 0;
        min-height: 112px;
        box-sizing: border-box;
        padding: 18px 18px 16px;
        border: 1px solid #e5e7eb;
        border-radius: 12px;
        background: #fff;
        box-shadow: 0 1px 2px rgba(15, 23, 42, .04);
    }

    .stock-summary-card p {
        margin: 0;
    }

    .stock-summary-card .stock-number {
        margin-top: 7px;
        line-height: 1;
    }

    .stock-summary-card .stock-note {
        margin-top: 8px;
        line-height: 1.35;
    }

    .stock-content {
        display: flex;
        flex-direction: column;
        gap: 22px;
        min-width: 0;
    }

    .stock-tabs {
        display: flex;
        align-items: flex-end;
        gap: 24px;
        min-height: 42px;
        border-bottom: 1px solid #e5e7eb;
    }

    .stock-tab {
        margin: 0;
        padding: 10px 2px 11px;
        line-height: 1;
        white-space: nowrap;
    }

    .stock-section {
        display: flex;
        flex-direction: column;
        gap: 16px;
        min-width: 0;
    }

    /* Only one stock section is visible at a time.
       This must override the display:flex rule above. */
    .stock-section.hidden {
        display: none !important;
    }

    .stock-toolbar {
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 18px;
    min-height: 42px;
}

.stock-search {
    width: 290px;
    max-width: 100%;
    height: 40px;
    box-sizing: border-box;
    flex: 0 0 290px;
}

.stock-filters {
    display: flex;
    align-items: center;
    justify-content: flex-end;
    gap: 10px;
    flex-wrap: nowrap;
}

.stock-control {
    min-height: 40px;
    height: 40px;
    box-sizing: border-box;
    white-space: nowrap;
    display: flex;
    align-items: center;
}
    .stock-table-card {
        width: 100%;
        overflow: hidden;
        border: 1px solid #e5e7eb;
        border-radius: 12px;
        background: #fff;
        box-shadow: 0 1px 2px rgba(15, 23, 42, .03);
    }

    .stock-table-wrap {
        width: 100%;
        overflow-x: auto;
    }

    .stock-table {
        width: 100%;
        min-width: 900px;
        border-collapse: separate;
        border-spacing: 0;
    }

    .stock-table th {
        padding: 12px 16px;
        text-align: left;
        white-space: nowrap;
        line-height: 1.25;
        background: #f8fafc;
        border-bottom: 1px solid #e5e7eb;
    }

    .stock-table td {
        padding: 14px 16px;
        vertical-align: middle;
        line-height: 1.35;
        white-space: nowrap;
    }

    .stock-table tbody tr {
        height: 58px;
    }

    .stock-table tbody tr + tr td {
        border-top: 1px solid #f1f5f9;
    }

    .stock-pagination {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 18px;
        min-height: 58px;
        padding: 10px 16px;
        border-top: 1px solid #e5e7eb;
    }

    .stock-pagination-buttons {
        display: flex;
        align-items: center;
        gap: 6px;
        flex-wrap: wrap;
    }

    .stock-pagination button {
        min-height: 36px;
        white-space: nowrap;
    }

    @media (max-width: 1100px) {
        .stock-summary-grid {
            grid-template-columns: repeat(2, minmax(0, 1fr));
        }
    }

    @media (max-width: 760px) {
        .stock-page {
            padding: 20px 16px 30px;
        }

        .stock-page-inner {
            gap: 22px;
        }

        .stock-header,
        .stock-toolbar,
        .stock-pagination {
            flex-direction: column;
            align-items: stretch;
        }

        .stock-actions,
        .stock-filters {
            justify-content: flex-start;
        }

        .stock-search {
            width: 100%;
            flex-basis: auto;
        }

        .stock-summary-grid {
            grid-template-columns: 1fr;
        }

        .stock-pagination-buttons {
            justify-content: flex-start;
        }
    }
</style>

<div class="stock-page">
<div class="stock-page-inner">

    {{-- Page Header --}}
    <div class="stock-header">
        <div class="stock-header-copy">
            <h1 class="text-2xl font-bold text-gray-900">Stock In</h1>
            <p class="mt-1 text-sm text-gray-500">
                Current, available inventory — pulled live from Inventory once connected.
            </p>
        </div>

        {{-- <div class="stock-actions">
            <button class="rounded-sm border border-gray-200 bg-blue-500 px-4 py-2.5 text-sm font-medium text-white hover:bg-gray-600">
                Export
            </button>
            <button class="rounded-sm bg-gray-900 px-4 py-2.5 text-sm font-medium text-white hover:bg-gray-600 hover:text-white">
                View Purchases
            </button>
        </div> --}}
    </div>

    {{-- Summary Cards --}}
    <div class="stock-summary-grid">

        <div class="stock-summary-card">
            <p class="text-sm text-gray-400">Total Items</p>
            <p class="stock-number text-3xl font-bold text-gray-900">{{ $stats['total_items'] }}</p>
            <p class="stock-note text-xs text-gray-400">{{ $stats['mobile_units'] }} mobiles, {{ $stats['accessory_items'] }} accessories</p>
        </div>

        <div class="stock-summary-card">
            <p class="text-sm text-gray-400">Mobile Units</p>
            <p class="stock-number text-3xl font-bold text-gray-900">{{ $stats['mobile_units'] }}</p>
            <p class="stock-note text-xs text-gray-400">Ready to sell, by IMEI</p>
        </div>

        <div class="stock-summary-card">
            <p class="text-sm text-gray-400">Accessory SKUs</p>
            <p class="stock-number text-3xl font-bold text-gray-900">{{ $stats['accessory_items'] }}</p>
            <p class="stock-note text-xs text-gray-400">Distinct accessory items</p>
        </div>

        <div class="stock-summary-card">
            <p class="text-sm text-gray-400">Low Stock</p>
            <p class="stock-number text-3xl font-bold text-red-600">{{ $stats['low_stock'] }}</p>
            <p class="stock-note text-xs text-red-500">At or below reorder level</p>
        </div>

    </div>

    {{-- Tabs + Tab Content, grouped so spacing above/below is consistent --}}
    <div class="stock-content">

        {{-- Category Tabs --}}
        <div class="stock-tabs">
            <button
                onclick="showStock('mobiles', this)"
                class="stock-tab border-b-2 border-gray-900 px-4 py-3 text-sm font-semibold text-gray-900">
                Mobiles
            </button>
            <button
                onclick="showStock('accessories', this)"
                class="stock-tab border-b-2 border-transparent px-4 py-3 text-sm font-semibold text-gray-500 hover:text-gray-800">
                Accessories
            </button>
        </div>

    {{-- ================= MOBILES ================= --}}
    <div id="mobiles" class="stock-section">

        {{-- Toolbar --}}
       <div class="stock-toolbar">
    <input
        type="text"
        placeholder="Search IMEI, model..."
        class="stock-search rounded-lg border border-gray-200 bg-white px-3.5 py-2.5 text-sm text-gray-700 outline-none placeholder:text-gray-400 focus:border-gray-400">

    <div class="stock-filters">
        <span class="stock-control rounded-lg border border-gray-200 bg-white px-3 py-2 text-sm text-gray-600">
            {{ $mobiles->count() }} records
        </span>

        <select class="stock-control rounded-lg border border-gray-200 bg-white px-3 py-2 text-sm text-gray-600 outline-none focus:border-gray-400">
            <option>All Conditions</option>
            <option>New</option>
            <option>Used</option>
        </select>

        <select class="stock-control rounded-lg border border-gray-200 bg-white px-3 py-2 text-sm text-gray-600 outline-none focus:border-gray-400">
            <option>All Locations</option>
            <option>Main Shop</option>
            <option>Branch 1</option>
        </select>
    </div>
</div>

        {{-- Table card --}}
        <div class="stock-table-card">
            <div class="stock-table-wrap">
                <table class="stock-table">
                    <thead>
                        <tr class="border-b border-gray-200 bg-gray-50">
                            <th class="text-sm font-medium text-gray-500">Product</th>
                            <th class="text-sm font-medium text-gray-500">IMEI</th>
                            <th class="text-sm font-medium text-gray-500">Condition</th>
                            <th class="text-sm font-medium text-gray-500">Location</th>
                            <th class="text-sm font-medium text-gray-500">Purchase Price</th>
                            <th class="text-sm font-medium text-gray-500">Status</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @forelse ($mobiles as $mobile)
                            <tr class="hover:bg-gray-50">
                                <td class="">
                                    <p class="font-medium text-gray-900">{{ $mobile->model }}</p>
                                    <p class="text-xs text-gray-400">{{ $mobile->brand }}</p>
                                </td>
                                <td class="font-mono text-sm text-blue-600">{{ $mobile->imei }}</td>
                                <td class="">
                                    <span class="rounded-full px-2.5 py-1 text-xs font-semibold {{ $conditionStyles[$mobile->condition] ?? 'bg-gray-50 text-gray-600' }}">
                                        {{ $mobile->condition }}
                                    </span>
                                </td>
                                <td class="text-sm text-gray-600">{{ $mobile->location }}</td>
                                <td class="text-sm font-medium text-gray-900">Rs. {{ $mobile->purchase_price }}</td>
                                <td class="">
                                    <span class="rounded-full px-2.5 py-1 text-xs font-semibold {{ $statusStyles[$mobile->status] ?? 'bg-gray-50 text-gray-600' }}">
                                        {{ $mobile->status }}
                                    </span>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="px-6 py-12 text-center text-sm text-gray-400">
                                    No mobiles in stock yet.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="stock-pagination">
                <p class="text-sm text-gray-500">
                    Showing <span class="font-medium text-gray-700">1</span> to
                    <span class="font-medium text-gray-700">{{ $mobiles->count() }}</span> of
                    <span class="font-medium text-gray-700">{{ $stats['mobile_units'] }}</span> mobiles
                </p>
                <div class="stock-pagination-buttons">
                    <button class="rounded-lg border border-gray-200 px-3 py-2 text-sm text-black bg-amber-50">Previous</button>
                    <button class="rounded-lg bg-gray-900 px-3 py-2 text-sm font-medium text-white">1</button>
                    <button class="rounded-lg border border-gray-200 px-3 py-2 text-sm text-gray-600 hover:bg-black hover:text-white">2</button>
                    <button class="rounded-lg border border-gray-200 px-3 py-2 text-sm text-gray-600 hover:bg-black hover:text-white">3</button>
                    <button class="rounded-lg border border-gray-200 px-3 py-2 text-sm text-black bg-amber-50">Next</button>
                </div>
            </div>
        </div>
    </div>

    {{-- ================= ACCESSORIES ================= --}}
    <div id="accessories" class="stock-section hidden">

     <div class="stock-toolbar">
    <input
        type="text"
        placeholder="Search products..."
        class="stock-search rounded-lg border border-gray-200 bg-white px-3.5 py-2.5 text-sm text-gray-700 outline-none placeholder:text-gray-400 focus:border-gray-400">

    <div class="stock-filters">
        <span class="stock-control rounded-lg border border-gray-200 bg-white px-3 py-2 text-sm text-gray-600">
            {{ $accessories->count() }} records
        </span>

        <select class="stock-control rounded-lg border border-gray-200 bg-white px-3 py-2 text-sm text-gray-600 outline-none focus:border-gray-400">
            <option>All Categories</option>
            <option>Chargers</option>
            <option>Power Banks</option>
            <option>Cases & Covers</option>
            <option>Screen Protectors</option>
            <option>Earphones</option>
        </select>

        <select class="stock-control rounded-lg border border-gray-200 bg-white px-3 py-2 text-sm text-gray-600 outline-none focus:border-gray-400">
            <option>All Locations</option>
            <option>Main Shop</option>
            <option>Branch 1</option>
        </select>
    </div>
</div>

        <div class="stock-table-card">
            <div class="stock-table-wrap">
                <table class="stock-table">
                    <thead>
                        <tr class="border-b border-gray-200 bg-gray-50">
                            <th class="text-sm font-medium text-gray-500">Product</th>
                            <th class="text-sm font-medium text-gray-500">SKU</th>
                            <th class="text-sm font-medium text-gray-500">Category</th>
                            <th class="text-sm font-medium text-gray-500">In Stock</th>
                            <th class="text-sm font-medium text-gray-500">Reorder Level</th>
                            <th class="text-sm font-medium text-gray-500">Status</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @forelse ($accessories as $accessory)
                            <tr class="hover:bg-gray-50">
                                <td class="font-medium text-gray-900">{{ $accessory->name }}</td>
                                <td class="font-mono text-sm text-blue-600">{{ $accessory->sku }}</td>
                                <td class="text-sm text-gray-600">{{ $accessory->category }}</td>
                                <td class="">
                                    @if ($accessory->quantity <= $accessory->reorder_level)
                                        <span class="rounded-full bg-red-50 px-2.5 py-0.5 text-sm font-semibold text-red-600">
                                            {{ $accessory->quantity }}
                                        </span>
                                    @else
                                        <span class="text-sm font-medium text-gray-900">{{ $accessory->quantity }}</span>
                                    @endif
                                </td>
                                <td class="text-sm font-medium text-blue-600">{{ $accessory->reorder_level }}</td>
                                <td class="">
                                    <span class="rounded-full px-2.5 py-1 text-xs font-semibold {{ $statusStyles[$accessory->status] ?? 'bg-gray-50 text-gray-600' }}">
                                        {{ $accessory->status }}
                                    </span>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="px-6 py-12 text-center text-sm text-gray-400">
                                    No accessories in stock yet.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="stock-pagination">
                <p class="text-sm text-gray-500">
                    Showing <span class="font-medium text-gray-700">1</span> to
                    <span class="font-medium text-gray-700">{{ $accessories->count() }}</span> of
                    <span class="font-medium text-gray-700">{{ $stats['accessory_items'] }}</span> accessories
                </p>
                <div class="stock-pagination-buttons">
                    <button class="rounded-lg border border-gray-200 px-3 py-2 text-sm text-black bg-amber-50">Previous</button>
                    <button class="rounded-lg bg-gray-900 px-3 py-2 text-sm font-medium text-white">1</button>
                    <button class="rounded-lg border border-gray-200 px-3 py-2 text-sm text-gray-600 hover:bg-black hover:text-white">2</button>
                    <button class="rounded-lg border border-gray-200 px-3 py-2 text-sm text-black bg-amber-50">Next</button>
                </div>
            </div>
        </div>
    </div>

    </div>
    {{-- /Tabs + Tab Content --}}

</div>
</div>

<script>
    function showStock(type, button) {
        // Hide every section first, then show ONLY the selected one.
        document.querySelectorAll('.stock-section').forEach(section => {
            section.classList.add('hidden');
        });

        const selectedSection = document.getElementById(type);
        if (selectedSection) {
            selectedSection.classList.remove('hidden');
        }

        document.querySelectorAll('.stock-tab').forEach(tab => {
            tab.classList.remove('border-gray-900', 'text-gray-900');
            tab.classList.add('border-transparent', 'text-gray-500');
        });

        button.classList.remove('border-transparent', 'text-gray-500');
        button.classList.add('border-gray-900', 'text-gray-900');
    }

    // Initial state: Mobiles open, Accessories hidden.
    document.addEventListener('DOMContentLoaded', function () {
        const mobileTab = document.querySelector('.stock-tab[onclick*="mobiles"]');
        if (mobileTab) {
            showStock('mobiles', mobileTab);
        }
    });
</script>

@endsection


{{-- sidebar.php --}}
{{-- <div class="nav-children" id="stock-menu">
    <a href="{{ url('/stock/in') }}" class="nav-link">Stock In</a>

    <a href="{{ url('/stock/out') }}" class="nav-link">Stock Out</a>

    <a href="{{ url('/stock/transfer') }}" class="nav-link">Stock Transfer</a>
</div> --}}


{{-- web.php --}}
