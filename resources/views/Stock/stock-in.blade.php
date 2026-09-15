@extends('layouts.app')

@push('styles')
<style>
    .page-header { margin-bottom: 20px; }
    .page-header h1 { font-size: 26px; font-weight: 800; color: #111827; margin: 0 0 4px 0; }
    .page-header p { font-size: 14px; color: #6b7280; margin: 0; }

    .top-stats { display: grid; grid-template-columns: repeat(4, minmax(0, 1fr)); gap: 16px; margin-bottom: 20px; }
    .stat-card { background: #fff; border: 1px solid #e5e7eb; border-radius: 12px; padding: 18px 20px; box-shadow: 0 1px 2px rgba(0,0,0,0.04); }
    .stat-card .label { display: block; color: #6b7280; font-size: 12px; font-weight: 700; text-transform: uppercase; letter-spacing: .04em; }
    .stat-card .value { display: block; font-size: 32px; font-weight: 800; color: #111827; margin-top: 8px; }
    .stat-card .note { display: block; color: #9ca3af; font-size: 12px; margin-top: 6px; }

    .toolbar { display: flex; align-items: center; justify-content: space-between; gap: 12px; margin-bottom: 16px; }
    .toolbar-left { display: flex; align-items: center; gap: 12px; flex-wrap: wrap; }
    .search-input { border: 1px solid #e5e7eb; background: #fff; border-radius: 8px; padding: 9px 14px; font-size: 14px; width: 260px; }
    .filter-select { border: 1px solid #e5e7eb; background: #fff; border-radius: 8px; padding: 9px 14px; font-size: 14px; }
    .record-badge { background: #fff; border: 1px solid #e5e7eb; border-radius: 8px; padding: 9px 16px; font-size: 14px; color: #374151; }

    .table-wrap { background: #fff; border-radius: 10px; overflow: hidden; box-shadow: 0 1px 2px rgba(0,0,0,0.04); }
    table.data-table { width: 100%; border-collapse: collapse; font-size: 14px; }
    table.data-table thead { background: #f3f4f6; }
    table.data-table thead th { text-align: left; font-size: 13px; font-weight: 600; color: #6b7280; padding: 14px 20px; }
    table.data-table tbody tr { border-top: 1px solid #f3f4f6; }
    table.data-table tbody tr:hover { background: #fafafa; }
    table.data-table td { padding: 16px 20px; color: #1f2937; vertical-align: middle; }
    .badge { display: inline-block; padding: 5px 10px; border-radius: 999px; font-size: 12px; font-weight: 700; }
    .badge-mobile { background: #ede9fe; color: #6d28d9; }
    .badge-accessory { background: #fef3c7; color: #92400e; }
    .status-pill { display: inline-flex; align-items: center; padding: 5px 10px; border-radius: 999px; font-size: 12px; font-weight: 700; }
    .status-in { background: #dcfce7; color: #166534; }
    .status-low { background: #fee2e2; color: #991b1b; }
    .empty-row { text-align: center; padding: 44px; color: #9ca3af; }
    .product-image { width: 52px; height: 52px; border-radius: 10px; object-fit: cover; border: 1px solid #e5e7eb; background: #f9fafb; }
    .product-name { font-weight: 700; color: #111827; }
    .mini-meta { color: #6b7280; font-size: 12px; margin-top: 3px; }
    .vendor-tag { color: #334155; font-weight: 600; }

    @media (max-width: 992px) {
        .top-stats { grid-template-columns: repeat(2, minmax(0, 1fr)); }
    }

    @media (max-width: 640px) {
        .top-stats { grid-template-columns: 1fr; }
        .toolbar { flex-direction: column; align-items: stretch; }
        .search-input { width: 100%; }
        .table-wrap { overflow-x: auto; }
        table.data-table { min-width: 820px; }
    }
</style>
@endpush

@section('content')
<div class="page-header">
    <h1>Stock In</h1>
    <p>All product stock currently available in the system, pulled from the product module.</p>
</div>

<div class="top-stats">
    <div class="stat-card">
        <span class="label">Total Products</span>
        <span class="value">{{ $stats['total_products'] }}</span>
        <span class="note">Products with available stock</span>
    </div>
    <div class="stat-card">
        <span class="label">Units</span>
        <span class="value">{{ $stats['total_units'] }}</span>
        <span class="note">Stock quantity on hand</span>
    </div>
    <div class="stat-card">
        <span class="label">Mobiles</span>
        <span class="value">{{ $stats['mobile_products'] }}</span>
        <span class="note">Mobile product entries</span>
    </div>
    <div class="stat-card">
        <span class="label">Accessories</span>
        <span class="value">{{ $stats['accessory_products'] }}</span>
        <span class="note">Accessory stock entries</span>
    </div>
</div>

<div class="toolbar">
    <div class="toolbar-left">
        <form method="GET" style="display:flex;gap:10px;flex-wrap:wrap;">
            <input type="text" name="search" value="{{ request('search') }}" class="search-input" placeholder="Search product, vendor...">
            <select name="type" class="filter-select" onchange="this.form.submit()">
                <option value="">All Types</option>
                <option value="mobile" {{ request('type') === 'mobile' ? 'selected' : '' }}>Mobile</option>
                <option value="accessory" {{ request('type') === 'accessory' ? 'selected' : '' }}>Accessory</option>
            </select>
        </form>
        <div class="record-badge">{{ $products->total() }} records</div>
    </div>
</div>

<div class="table-wrap">
    <table class="data-table">
        <thead>
            <tr>
                <th>Image</th>
                <th>Product</th>
                <th>Type</th>
                <th>Vendor</th>
                <th>Category</th>
                <th>Subcategory</th>
                <th>Qty</th>
                <th>Status</th>
                <th>Branch</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($products as $product)
                @php
                    $firstItem = $product->items->first();
                    $status = $product->quantity <= 5 ? 'Low Stock' : 'In Stock';
                    $branchName = $firstItem && $firstItem->branch ? $firstItem->branch->name : '—';
                    $displayName = $product->type === 'mobile'
                        ? ($firstItem->model ?? 'Mobile Product')
                        : ($firstItem->brand ?? 'Accessory Product');
                @endphp
                <tr>
                    <td>
                        @if ($firstItem && $firstItem->image)
                            <img src="{{ asset('storage/' . $firstItem->image) }}" alt="{{ $displayName }}" class="product-image">
                        @else
                            <div class="product-image flex items-center justify-center text-gray-400 text-xs">No Image</div>
                        @endif
                    </td>
                    <td>
                        <div class="product-name">{{ $displayName }}</div>
                        <div class="mini-meta">{{ $product->vendor->name ?? 'Unknown Vendor' }}</div>
                    </td>
                    <td>
                        <span class="badge {{ $product->type === 'mobile' ? 'badge-mobile' : 'badge-accessory' }}">
                            {{ ucfirst($product->type) }}
                        </span>
                    </td>
                    <td class="vendor-tag">{{ $product->vendor->name ?? '—' }}</td>
                    <td>{{ $product->category->name ?? '—' }}</td>
                    <td>{{ $product->subcategory->name ?? '—' }}</td>
                    <td>{{ $product->quantity }}</td>
                    <td>
                        <span class="status-pill {{ $status === 'Low Stock' ? 'status-low' : 'status-in' }}">
                            {{ $status }}
                        </span>
                    </td>
                    <td>{{ $branchName }}</td>
                </tr>
            @empty
                <tr><td colspan="9" class="empty-row">No stock products found.</td></tr>
            @endforelse
        </tbody>
    </table>
</div>

<div style="margin-top:16px;">{{ $products->withQueryString()->links() }}</div>
@endsection

