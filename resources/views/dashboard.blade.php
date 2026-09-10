@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
    <h2>Dashboard</h2>
    <p class="subtitle">Real-time overview of sales, finance, and operations</p>

    <div class="cards-row">
        <div class="stat-card">
            <div class="stat-icon blue">🛒</div>
            <p class="stat-label">Total Sale Amount</p>
            <h3>₨100,649,489</h3>
        </div>
        <div class="stat-card">
            <div class="stat-icon orange">⚠️</div>
            <p class="stat-label">Total Sale Due</p>
            <h3>₨51,679,876</h3>
        </div>
        <div class="stat-card">
            <div class="stat-icon purple">📦</div>
            <p class="stat-label">Total Purchase Amount</p>
            <h3>₨20,459,893</h3>
        </div>
        <div class="stat-card">
            <div class="stat-icon red">📉</div>
            <p class="stat-label">Total Purchase Due</p>
            <h3>₨17,549,796</h3>
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
