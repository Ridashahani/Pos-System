@extends('layouts.app')

@section('content')

<style>
    /* Stock Transfer - same layout/spacing system as Stock Out */
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
        max-width: 620px;
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
        background: transparent;
        border: 0;
        cursor: pointer;
    }

    .stock-section {
        display: flex;
        flex-direction: column;
        gap: 16px;
        min-width: 0;
    }

    .stock-section.hidden {
        display: none !important;
    }

    .stock-panel {
        width: 100%;
        box-sizing: border-box;
        padding: 22px;
        border: 1px solid #e5e7eb;
        border-radius: 12px;
        background: #fff;
        box-shadow: 0 1px 2px rgba(15, 23, 42, .04);
    }

    .stock-panel-header {
        margin-bottom: 18px;
    }

    .stock-panel-header h2 {
        margin: 0;
        line-height: 1.25;
    }

    .stock-panel-header p {
        margin: 6px 0 0;
        line-height: 1.4;
    }

    .stock-toolbar {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 18px;
        min-height: 42px;
        margin-bottom: 16px;
    }

    .stock-search {
        width: 300px;
        max-width: 100%;
        height: 40px;
        box-sizing: border-box;
        flex: 0 1 300px;
    }

    .stock-filters {
        display: flex;
        align-items: center;
        justify-content: flex-end;
        gap: 10px;
        flex-wrap: wrap;
    }

    .stock-control {
        min-height: 40px;
        box-sizing: border-box;
        white-space: nowrap;
    }

    .stock-table-card {
        width: 100%;
        overflow: hidden;
        border: 1px solid #e5e7eb;
        border-radius: 10px;
        background: #fff;
    }

    .stock-table-wrap {
        width: 100%;
        overflow-x: auto;
    }

    .stock-table {
        width: 100%;
        min-width: 760px;
        border-collapse: separate;
        border-spacing: 0;
        table-layout: auto;
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

    .stock-table tbody tr:hover {
        background: #f8fafc;
    }

    @media (max-width: 900px) {
        .stock-toolbar {
            align-items: stretch;
            flex-direction: column;
        }

        .stock-search {
            width: 100%;
            flex-basis: auto;
        }

        .stock-filters {
            justify-content: flex-start;
        }
    }

    @media (max-width: 760px) {
        .stock-page {
            padding: 20px 16px 30px;
        }

        .stock-page-inner {
            gap: 22px;
        }

        .stock-header {
            gap: 16px;
        }

        .stock-panel {
            padding: 18px;
        }

        .stock-filters {
            align-items: stretch;
            flex-direction: column;
        }

        .stock-control {
            width: 100%;
        }
    }
</style>

<div class="stock-page">

<div class="stock-page-inner">

    {{-- Page Header --}}
    <div class="stock-header">

        <div class="stock-header-copy">

            <h1 class="text-2xl font-bold text-gray-900">
                Stock Transfer
            </h1>

            <p class="text-sm text-gray-500">
                Transfer stock between locations
            </p>

        </div>

        <button
            type="button"
            class="rounded-lg bg-gray-900 px-5 py-2.5 text-sm font-semibold text-white shadow-sm hover:bg-gray-800">
            + New Transfer
        </button>

    </div>


    {{-- Tabs + Content --}}
    <div class="stock-content">

        {{-- Category Tabs --}}
        <div class="stock-tabs">

            <button
                type="button"
                onclick="showStock('mobiles', this)"
                class="stock-tab border-b-2 border-gray-900 text-sm font-semibold text-gray-900">

                📱 Mobiles

            </button>

            <button
                type="button"
                onclick="showStock('accessories', this)"
                class="stock-tab border-b-2 border-transparent text-sm font-semibold text-gray-500 hover:text-gray-800">

                🔌 Accessories

            </button>

        </div>


        {{-- ================= MOBILES ================= --}}
        <div id="mobiles" class="stock-section">

            <div class="stock-panel">

                <div class="stock-panel-header">

                    <h2 class="text-lg font-semibold text-gray-900">
                        Mobile Transfers
                    </h2>

                    <p class="text-sm text-gray-500">
                        Mobile stock moved between locations
                    </p>

                </div>


                {{-- Filters --}}
                <div class="stock-toolbar">

                    <input
                        type="text"
                        placeholder="Search model or IMEI..."
                        class="stock-search rounded-lg border border-gray-200 bg-white px-3.5 py-2.5 text-sm text-gray-700 outline-none placeholder:text-gray-400 focus:border-gray-400">


                    <div class="stock-filters">

                        <select
                            class="stock-control rounded-lg border border-gray-200 bg-white px-3 py-2 text-sm text-gray-600 outline-none focus:border-gray-400">

                            <option>All Locations</option>
                            <option>Main Shop</option>
                            <option>Branch 1</option>
                            <option>Branch 2</option>

                        </select>

                    </div>

                </div>


                {{-- Table --}}
                <div class="stock-table-card">

                    <div class="stock-table-wrap">

                        <table class="stock-table">

                            <thead>

                                <tr>

                                    <th class="text-sm font-medium text-gray-500">
                                        Model
                                    </th>

                                    <th class="text-sm font-medium text-gray-500">
                                        IMEI
                                    </th>

                                    <th class="text-sm font-medium text-gray-500">
                                        From
                                    </th>

                                    <th class="text-sm font-medium text-gray-500">
                                        To
                                    </th>

                                    <th class="text-sm font-medium text-gray-500">
                                        Date
                                    </th>

                                    <th class="text-sm font-medium text-gray-500">
                                        Status
                                    </th>

                                </tr>

                            </thead>


                            <tbody>

                                <tr>

                                    <td class="font-medium text-gray-900">
                                        iPhone 13
                                    </td>

                                    <td class="font-mono text-sm text-blue-600">
                                        359876543210123
                                    </td>

                                    <td class="text-gray-600">
                                        Main Shop
                                    </td>

                                    <td class="text-gray-600">
                                        Branch 1
                                    </td>

                                    <td class="text-gray-600">
                                        10 Sep 2026
                                    </td>

                                    <td>

                                        <span class="rounded-full bg-green-50 px-2.5 py-1 text-xs font-semibold text-green-700">
                                            Completed
                                        </span>

                                    </td>

                                </tr>


                                <tr>

                                    <td class="font-medium text-gray-900">
                                        Samsung A15
                                    </td>

                                    <td class="font-mono text-sm text-blue-600">
                                        352099123456789
                                    </td>

                                    <td class="text-gray-600">
                                        Branch 1
                                    </td>

                                    <td class="text-gray-600">
                                        Main Shop
                                    </td>

                                    <td class="text-gray-600">
                                        08 Sep 2026
                                    </td>

                                    <td>

                                        <span class="rounded-full bg-green-50 px-2.5 py-1 text-xs font-semibold text-green-700">
                                            Completed
                                        </span>

                                    </td>

                                </tr>

                            </tbody>

                        </table>

                    </div>

                </div>

            </div>

        </div>


        {{-- ================= ACCESSORIES ================= --}}
        <div id="accessories" class="stock-section hidden">

            <div class="stock-panel">

                <div class="stock-panel-header">

                    <h2 class="text-lg font-semibold text-gray-900">
                        Accessory Transfers
                    </h2>

                    <p class="text-sm text-gray-500">
                        Accessory stock moved between locations
                    </p>

                </div>


                {{-- Filters --}}
                <div class="stock-toolbar">

                    <input
                        type="text"
                        placeholder="Search accessory..."
                        class="stock-search rounded-lg border border-gray-200 bg-white px-3.5 py-2.5 text-sm text-gray-700 outline-none placeholder:text-gray-400 focus:border-gray-400">


                    <div class="stock-filters">

                        <select
                            class="stock-control rounded-lg border border-gray-200 bg-white px-3 py-2 text-sm text-gray-600 outline-none focus:border-gray-400">

                            <option>All Locations</option>
                            <option>Main Shop</option>
                            <option>Branch 1</option>
                            <option>Branch 2</option>

                        </select>

                    </div>

                </div>


                {{-- Table --}}
                <div class="stock-table-card">

                    <div class="stock-table-wrap">

                        <table class="stock-table">

                            <thead>

                                <tr>

                                    <th class="text-sm font-medium text-gray-500">
                                        Item
                                    </th>

                                    <th class="text-sm font-medium text-gray-500">
                                        Quantity
                                    </th>

                                    <th class="text-sm font-medium text-gray-500">
                                        From
                                    </th>

                                    <th class="text-sm font-medium text-gray-500">
                                        To
                                    </th>

                                    <th class="text-sm font-medium text-gray-500">
                                        Date
                                    </th>

                                    <th class="text-sm font-medium text-gray-500">
                                        Status
                                    </th>

                                </tr>

                            </thead>


                            <tbody>

                                <tr>

                                    <td class="font-medium text-gray-900">
                                        Charger
                                    </td>

                                    <td class="font-semibold text-gray-900">
                                        10
                                    </td>

                                    <td class="text-gray-600">
                                        Main Shop
                                    </td>

                                    <td class="text-gray-600">
                                        Branch 1
                                    </td>

                                    <td class="text-gray-600">
                                        10 Sep 2026
                                    </td>

                                    <td>

                                        <span class="rounded-full bg-green-50 px-2.5 py-1 text-xs font-semibold text-green-700">
                                            Completed
                                        </span>

                                    </td>

                                </tr>


                                <tr>

                                    <td class="font-medium text-gray-900">
                                        Protector
                                    </td>

                                    <td class="font-semibold text-gray-900">
                                        20
                                    </td>

                                    <td class="text-gray-600">
                                        Branch 1
                                    </td>

                                    <td class="text-gray-600">
                                        Main Shop
                                    </td>

                                    <td class="text-gray-600">
                                        08 Sep 2026
                                    </td>

                                    <td>

                                        <span class="rounded-full bg-green-50 px-2.5 py-1 text-xs font-semibold text-green-700">
                                            Completed
                                        </span>

                                    </td>

                                </tr>

                            </tbody>

                        </table>

                    </div>

                </div>

            </div>

        </div>

    </div>

</div>


</div>

<script>

    function showStock(type, button) {

        document.querySelectorAll('.stock-section').forEach(section => {
            section.classList.add('hidden');
        });

        const selectedSection = document.getElementById(type);

        if (selectedSection) {
            selectedSection.classList.remove('hidden');
        }


        document.querySelectorAll('.stock-tab').forEach(tab => {

            tab.classList.remove(
                'border-gray-900',
                'text-gray-900'
            );

            tab.classList.add(
                'border-transparent',
                'text-gray-500'
            );

        });


        button.classList.remove(
            'border-transparent',
            'text-gray-500'
        );

        button.classList.add(
            'border-gray-900',
            'text-gray-900'
        );

    }


    document.addEventListener('DOMContentLoaded', function () {

        const firstTab = document.querySelector('.stock-tab');

        if (firstTab) {
            showStock('mobiles', firstTab);
        }

    });

</script>

@endsection
