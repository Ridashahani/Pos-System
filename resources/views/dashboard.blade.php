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
    <h2 class="dashboard-title">Dashboard</h2>
    <p class="subtitle">Real-time overview of sales, finance, and operations</p>

    <div class="cards-row">
        <div class="stat-card">
            <div class="stat-icon blue">🛒</div>
            <p class="stat-label">Today's Sales</p>
            <h3>Rs {{ number_format($todaySales ?? 0) }}</h3>
            <p class="stat-hint">{{ $todayInvoiceCount ?? 0 }} invoice(s)</p>
        </div>
        <div class="stat-card">
            <div class="stat-icon green">📈</div>
            <p class="stat-label">Gross Profit (all-time)</p>
            <h3>Rs {{ number_format($grossProfit ?? 0) }}</h3>
            <p class="stat-hint ok">revenue – cost of goods</p>
        </div>
        <div class="stat-card">
            <div class="stat-icon red">⚠️</div>
            <p class="stat-label">Low Stock Items</p>
            <h3>{{ $lowStockCount ?? 0 }}</h3>
            <p class="stat-hint warn">at or below reorder level</p>
        </div>

        <div class="stat-card">
            <div class="stat-icon purple">💳</div>
            <p class="stat-label">Instalments Pending</p>
            <h3>{{ $pendingInstalments ?? 0 }}</h3>
            <p class="stat-hint">across customers</p>
        </div>

    </div>
    <div class="panels-row">
        <div class="panel">
            <h4>Recent Sales</h4>
            <table class="sales-table">
                <thead>
                    <tr>
                        <th>Invoice</th>
                        <th>Customer</th>
                        <th>Total</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($recentSales as $sale)
                        <tr>
                            <td class="invoice-no">{{ $sale->invoice_no }}</td>
                            <td class="customer-name">{{ $sale->customer_name }}</td>
                            <td class="total-amount">Rs {{ number_format($sale->total) }}</td>
                            <td>
                                <span class="badge badge-{{ strtolower($sale->status) }}">
                                    {{ $sale->status }}
                                </span>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="panel">
            <h4>Low Stock Alerts</h4>
            <ul class="stock-list">
                @foreach ($lowStockItems as $item)
                    <li>
                        <span>{{ $item->name }}</span>
                        <span class="stock-left">{{ $item->qty }} left</span>
                    </li>
                @endforeach
            </ul>
        </div>
    </div>

    <div class="charts-row">
        <div class="chart-box">
            <h4>Sales (Paid / Due / Return)</h4>
            <div class="donut-placeholder">
                <div class="donut-center">
                    <p>Paid</p>
                    <h3>₨50,938,298</h3>
                    <span>49.6%</span>
                </div>
            </div>
            <ul class="legend">
                <li><span class="dot orange"></span> Due (₨51,679,876)</li>
                <li><span class="dot blue"></span> Paid (₨50,938,298)</li>
                <li><span class="dot red"></span> Return (₨128,762)</li>
            </ul>
        </div>

        <div class="chart-box">
            <h4>Sales vs Purchases (Monthly)</h4>
            <div class="line-placeholder">
                <p class="placeholder-text">Chart area (static)</p>
            </div>
        </div>
    </div>
@endsection
