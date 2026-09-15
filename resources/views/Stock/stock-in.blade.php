@extends('layouts.app')

@section('content')
@push('styles')
<style>
    .page-header { margin-bottom: 20px; }
    .page-header h1 { font-size: 28px; font-weight: 800; color: #111827; margin: 0 0 6px; }
    .page-header p { margin: 0; font-size: 14px; color: #6b7280; }

    .top-stats { display: grid; grid-template-columns: repeat(4, minmax(0, 1fr)); gap: 16px; margin-bottom: 20px; }
    .stat-card { background: #fff; border: 1px solid #e5e7eb; border-radius: 12px; padding: 18px 20px; box-shadow: 0 1px 2px rgba(0,0,0,0.04); }
    .stat-card .label { display: block; color: #6b7280; font-size: 11px; letter-spacing: .06em; text-transform: uppercase; font-weight: 700; }
    .stat-card .value { display: block; margin-top: 8px; font-size: 30px; font-weight: 800; color: #111827; }
    .stat-card .note { display: block; margin-top: 6px; font-size: 12px; color: #9ca3af; }

    .toolbar { display: flex; align-items: center; justify-content: space-between; gap: 12px; margin-bottom: 16px; }
    .toolbar-left { display: flex; align-items: center; gap: 12px; flex-wrap: wrap; }
    .search-input { width: 260px; border: 1px solid #e5e7eb; border-radius: 8px; background: #fff; padding: 9px 14px; font-size: 14px; }
    .filter-select { border: 1px solid #e5e7eb; border-radius: 8px; background: #fff; padding: 9px 14px; font-size: 14px; }
    .record-badge { background: #fff; border: 1px solid #e5e7eb; border-radius: 8px; padding: 9px 16px; font-size: 14px; color: #374151; }

    .table-wrap { background: #fff; border: 1px solid #e5e7eb; border-radius: 12px; overflow: hidden; box-shadow: 0 1px 2px rgba(0,0,0,0.04); }
    table.data-table { width: 100%; border-collapse: collapse; font-size: 14px; }
    table.data-table thead { background: #f3f4f6; }
    table.data-table thead th { text-align: left; padding: 14px 18px; font-size: 12px; font-weight: 700; color: #6b7280; letter-spacing: .04em; text-transform: uppercase; }
    table.data-table tbody tr { border-top: 1px solid #f3f4f6; }
    table.data-table tbody tr:hover { background: #fafafa; }
    table.data-table td { padding: 14px 18px; vertical-align: middle; color: #1f2937; }

    .product-image-wrap { width: 52px; height: 52px; border-radius: 10px; overflow: hidden; background: #f8fafc; border: 1px solid #e5e7eb; display: flex; align-items: center; justify-content: center; }
    .product-image { width: 100%; height: 100%; object-fit: cover; }
    .product-name { font-weight: 700; color: #111827; }
    .mini-meta { margin-top: 4px; font-size: 12px; color: #6b7280; }
    .badge { display: inline-block; padding: 5px 10px; border-radius: 999px; font-size: 12px; font-weight: 700; }
    .badge-mobile { background: #ede9fe; color: #6d28d9; }
    .badge-accessory { background: #fef3c7; color: #92400e; }
    .price-tag { font-weight: 700; color: #111827; }
    .status-pill { display: inline-flex; align-items: center; padding: 5px 10px; border-radius: 999px; font-size: 12px; font-weight: 700; }
    .status-in { background: #dcfce7; color: #166534; }
    .status-low { background: #fee2e2; color: #991b1b; }
    .detail-btn { width: 34px; height: 34px; border-radius: 8px; border: 1px solid #e5e7eb; background: #fff; color: #4f46e5; font-size: 18px; cursor: pointer; }
    .detail-btn:hover { background: #eef2ff; border-color: #dfe5ff; }
    .empty-row { text-align: center; padding: 46px; color: #9ca3af; }

    .slider-wrap { margin-top: 20px; }
    .slider-head { display: flex; align-items: center; justify-content: space-between; margin-bottom: 12px; }
    .slider-head h3 { margin: 0; font-size: 18px; font-weight: 700; color: #111827; }
    .slider-head span { font-size: 13px; color: #6b7280; }
    .slider-box { display: flex; gap: 14px; overflow-x: auto; padding-bottom: 10px; }
    .slider-box::-webkit-scrollbar { height: 8px; }
    .slider-box::-webkit-scrollbar-thumb { background: #d1d5db; border-radius: 999px; }
    .slider-card { min-width: 220px; max-width: 220px; background: #fff; border: 1px solid #e5e7eb; border-radius: 14px; padding: 12px; box-shadow: 0 1px 2px rgba(0,0,0,0.04); }
    .slider-thumb { width: 100%; height: 110px; border-radius: 10px; background: linear-gradient(135deg, #eef2ff, #f8fafc); border: 1px solid #e5e7eb; display: flex; align-items: center; justify-content: center; overflow: hidden; color: #6b7280; font-weight: 700; }
    .slider-thumb img { width: 100%; height: 100%; object-fit: cover; }
    .slider-card h4 { margin: 12px 0 6px; font-size: 15px; font-weight: 700; color: #111827; }
    .slider-card p { margin: 0; font-size: 12px; color: #6b7280; }
    .slider-meta { display: flex; align-items: center; justify-content: space-between; margin-top: 12px; }
    .slider-price { font-weight: 800; color: #111827; }
    .slider-qty { font-size: 11px; color: #6b7280; }

    .modal { display: none; position: fixed; inset: 0; background: rgba(15, 23, 42, 0.45); z-index: 50; align-items: center; justify-content: center; }
    .modal.show { display: flex; }
    .modal-card { width: min(640px, calc(100% - 30px)); background: #fff; border-radius: 16px; border: 1px solid #e5e7eb; box-shadow: 0 20px 45px rgba(15,23,42,.18); }
    .modal-head { display: flex; align-items: center; justify-content: space-between; padding: 18px 20px; border-bottom: 1px solid #e5e7eb; }
    .modal-head h3 { margin: 0; font-size: 20px; font-weight: 800; color: #111827; }
    .close-btn { border: none; background: transparent; color: #6b7280; font-size: 26px; cursor: pointer; }
    .modal-body { display: grid; grid-template-columns: repeat(2, minmax(0,1fr)); gap: 16px; padding: 20px; }
    .detail-box { background: #f8fafc; border: 1px solid #e5e7eb; border-radius: 10px; padding: 14px; }
    .detail-box .label { display: block; font-size: 11px; letter-spacing: .06em; text-transform: uppercase; font-weight: 700; color: #6b7280; }
    .detail-box .value { display: block; margin-top: 8px; font-size: 15px; font-weight: 700; color: #111827; }

    @media (max-width: 992px) { .top-stats { grid-template-columns: repeat(2, minmax(0,1fr)); } }
    @media (max-width: 640px) {
        .top-stats { grid-template-columns: 1fr; }
        .toolbar { flex-direction: column; align-items: stretch; }
        .search-input { width: 100%; }
        .table-wrap { overflow-x: auto; }
        table.data-table { min-width: 1000px; }
        .modal-body { grid-template-columns: 1fr; }
    }
</style>
@endpush

<div class="page-header">
    <h1>Stock In</h1>
    <p>All product stock currently available in the system, pulled from the product module.</p>
</div>

<div class="top-stats">
    <div class="stat-card">
        <span class="label">Total Products</span>
        <span class="value">{{ $stats['total_products'] }}</span>
        <span class="note">Products with stock</span>
    </div>
    <div class="stat-card">
        <span class="label">Units</span>
        <span class="value">{{ $stats['total_units'] }}</span>
        <span class="note">Available inventory</span>
    </div>
    <div class="stat-card">
        <span class="label">Mobiles</span>
        <span class="value">{{ $stats['mobile_products'] }}</span>
        <span class="note">Mobile stock items</span>
    </div>
    <div class="stat-card">
        <span class="label">Accessories</span>
        <span class="value">{{ $stats['accessory_products'] }}</span>
        <span class="note">Accessory stock items</span>
    </div>
</div>

<div class="toolbar">
    <div class="toolbar-left">
        <form method="GET" style="display:flex; gap:10px; flex-wrap:wrap;">
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
                <th>Purchase Price</th>
                <th>Status</th>
                <th style="text-align:right;">Details</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($products as $product)
                @php
                    $firstItem = $product->items->first();
                    $status = $product->quantity <= 5 ? 'Low Stock' : 'In Stock';
                    $purchasePrice = $firstItem ? ($firstItem->purchase_price ?? $firstItem->purchase_amount ?? 0) : 0;
                    $displayName = $product->type === 'mobile'
                        ? ($firstItem->model ?? 'Mobile Product')
                        : ($firstItem->brand ?? 'Accessory Product');
                @endphp
                <tr>
                    <td>
                        @if ($firstItem && $firstItem->image)
                            <div class="product-image-wrap">
                                <img src="{{ asset('storage/' . $firstItem->image) }}" alt="{{ $displayName }}" class="product-image">
                            </div>
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
                    <td>{{ $product->vendor->name ?? '—' }}</td>
                    <td>{{ $product->category->name ?? '—' }}</td>
                    <td>{{ $product->subcategory->name ?? '—' }}</td>
                    <td>{{ $product->quantity }}</td>
                    <td class="price-tag">Rs. {{ number_format($purchasePrice, 2) }}</td>
                    <td>
                        <span class="status-pill {{ $status === 'Low Stock' ? 'status-low' : 'status-in' }}">{{ $status }}</span>
                    </td>
                    <td style="text-align:right;">
                        <button type="button"
                            class="detail-btn"
                            data-name="{{ $displayName }}"
                            data-vendor="{{ $product->vendor->name ?? 'Unknown Vendor' }}"
                            data-category="{{ $product->category->name ?? '—' }}"
                            data-subcategory="{{ $product->subcategory->name ?? '—' }}"
                            data-type="{{ ucfirst($product->type) }}"
                            data-quantity="{{ $product->quantity }}"
                            data-price="Rs. {{ number_format($purchasePrice, 2) }}"
                            data-status="{{ $status }}"
                            data-branch="{{ $firstItem && $firstItem->branch ? $firstItem->branch->name : '—' }}"
                            data-brand="{{ $firstItem->brand ?? '—' }}"
                            data-model="{{ $firstItem->model ?? '—' }}"
                            data-imei="{{ $firstItem->imei ?? '—' }}"
                            aria-label="View stock details">
                            👁
                        </button>
                    </td>
                </tr>
            @empty
                <tr><td colspan="10" class="empty-row">No stock products found.</td></tr>
            @endforelse
        </tbody>
    </table>
</div>

<div class="slider-wrap">
    <div class="slider-head">
        <h3>Top Stock Products</h3>
        <span>{{ $sliderProducts->count() }} items</span>
    </div>
    <div class="slider-box">
        @foreach ($sliderProducts as $product)
            @php
                $firstSliderItem = $product->items->first();
                $sliderPurchasePrice = $firstSliderItem ? ($firstSliderItem->purchase_price ?? $firstSliderItem->purchase_amount ?? 0) : 0;
                $sliderDisplayName = $product->type === 'mobile'
                    ? ($firstSliderItem->model ?? 'Mobile Product')
                    : ($firstSliderItem->brand ?? 'Accessory Product');
            @endphp
            <div class="slider-card">
                <div class="slider-thumb">
                    @if ($firstSliderItem && $firstSliderItem->image)
                        <img src="{{ asset('storage/' . $firstSliderItem->image) }}" alt="{{ $sliderDisplayName }}">
                    @else
                        {{ strtoupper(substr($sliderDisplayName, 0, 2)) }}
                    @endif
                </div>
                <h4>{{ $sliderDisplayName }}</h4>
                <p>{{ $product->vendor->name ?? 'Unknown Vendor' }}</p>
                <div class="slider-meta">
                    <span class="slider-price">Rs. {{ number_format($sliderPurchasePrice, 2) }}</span>
                    <span class="slider-qty">Qty: {{ $product->quantity }}</span>
                </div>
            </div>
        @endforeach
    </div>
</div>

<div style="margin-top:16px;">{{ $products->withQueryString()->links() }}</div>

<div class="modal" id="productModal" aria-hidden="true">
    <div class="modal-card">
        <div class="modal-head">
            <h3 id="modalTitle">Product Details</h3>
            <button type="button" class="close-btn" data-close="modal">&times;</button>
        </div>
        <div class="modal-body">
            <div class="detail-box"><span class="label">Product</span><span class="value" id="modalName">—</span></div>
            <div class="detail-box"><span class="label">Vendor</span><span class="value" id="modalVendor">—</span></div>
            <div class="detail-box"><span class="label">Category</span><span class="value" id="modalCategory">—</span></div>
            <div class="detail-box"><span class="label">Subcategory</span><span class="value" id="modalSubcategory">—</span></div>
            <div class="detail-box"><span class="label">Type</span><span class="value" id="modalType">—</span></div>
            <div class="detail-box"><span class="label">Quantity</span><span class="value" id="modalQuantity">—</span></div>
            <div class="detail-box"><span class="label">Purchase Price</span><span class="value" id="modalPrice">—</span></div>
            <div class="detail-box"><span class="label">Status</span><span class="value" id="modalStatus">—</span></div>
            <div class="detail-box"><span class="label">Branch</span><span class="value" id="modalBranch">—</span></div>
            <div class="detail-box"><span class="label">Brand</span><span class="value" id="modalBrand">—</span></div>
            <div class="detail-box"><span class="label">Model</span><span class="value" id="modalModel">—</span></div>
            <div class="detail-box"><span class="label">IMEI</span><span class="value" id="modalImei">—</span></div>
        </div>
    </div>
</div>

<script>
    const modal = document.getElementById('productModal');
    document.querySelectorAll('.detail-btn').forEach((button) => {
        button.addEventListener('click', function () {
            document.getElementById('modalTitle').textContent = this.dataset.name;
            document.getElementById('modalName').textContent = this.dataset.name;
            document.getElementById('modalVendor').textContent = this.dataset.vendor;
            document.getElementById('modalCategory').textContent = this.dataset.category;
            document.getElementById('modalSubcategory').textContent = this.dataset.subcategory;
            document.getElementById('modalType').textContent = this.dataset.type;
            document.getElementById('modalQuantity').textContent = this.dataset.quantity;
            document.getElementById('modalPrice').textContent = this.dataset.price;
            document.getElementById('modalStatus').textContent = this.dataset.status;
            document.getElementById('modalBranch').textContent = this.dataset.branch;
            document.getElementById('modalBrand').textContent = this.dataset.brand;
            document.getElementById('modalModel').textContent = this.dataset.model;
            document.getElementById('modalImei').textContent = this.dataset.imei;
            modal.classList.add('show');
        });
    });

    document.querySelectorAll('[data-close="modal"]').forEach((button) => {
        button.addEventListener('click', function () {
            modal.classList.remove('show');
        });
    });

    modal.addEventListener('click', function (event) {
        if (event.target === modal) {
            modal.classList.remove('show');
        }
    });
</script>
@endsection
