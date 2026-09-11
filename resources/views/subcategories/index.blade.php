{{-- resources/views/subcategories/index.blade.php --}}
@extends('layouts.app')

@push('styles')
<style>
    .page-header {
        margin-bottom: 20px;
    }
    .page-header h1 {
        font-size: 26px;
        font-weight: 800;
        color: #111827;
        margin: 0 0 4px 0;
    }
    .page-header p {
        font-size: 14px;
        color: #6b7280;
        margin: 0;
    }

    .toolbar {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-bottom: 16px;
    }
    .toolbar-left {
        display: flex;
        align-items: center;
        gap: 12px;
    }
    .search-input {
        border: 1px solid #e5e7eb;
        background: #fff;
        border-radius: 8px;
        padding: 9px 14px;
        font-size: 14px;
        width: 260px;
    }
    .record-badge {
        background: #fff;
        border: 1px solid #e5e7eb;
        border-radius: 8px;
        padding: 9px 16px;
        font-size: 14px;
        color: #374151;
        white-space: nowrap;
    }
    .btn-add {
        background: #f5a524;
        color: #1f2937;
        border: none;
        padding: 11px 20px;
        border-radius: 8px;
        font-size: 14px;
        font-weight: 700;
        text-decoration: none;
        cursor: pointer;
    }
    .btn-add:hover { background: #e6980f; }

    .table-wrap {
        background: #fff;
        border-radius: 10px;
        overflow: hidden;
        box-shadow: 0 1px 2px rgba(0,0,0,0.04);
    }
    table.data-table {
        width: 100%;
        border-collapse: collapse;
        font-size: 14px;
    }
    table.data-table thead {
        background: #f3f4f6;
    }
    table.data-table thead th {
        text-align: left;
        font-size: 13px;
        font-weight: 600;
        color: #6b7280;
        padding: 14px 24px;
    }
    table.data-table thead th.actions-col {
        text-align: right;
    }
    table.data-table tbody tr {
        border-top: 1px solid #f3f4f6;
    }
    table.data-table tbody tr:hover {
        background: #fafafa;
    }
    table.data-table td {
        padding: 16px 24px;
        color: #1f2937;
    }
    td.actions-cell {
        text-align: right;
    }

    .icon-btn {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        width: 32px;
        height: 32px;
        border: 1px solid #e5e7eb;
        border-radius: 8px;
        background: #fff;
        cursor: pointer;
        margin-left: 6px;
    }
    .icon-btn.edit:hover { background: #eef2ff; border-color: #c7d2fe; }
    .icon-btn.delete:hover { background: #fef2f2; border-color: #fecaca; }
    .icon-btn svg { width: 15px; height: 15px; }

    .empty-row {
        text-align: center;
        padding: 40px;
        color: #9ca3af;
    }
</style>
@endpush

@section('content')

<div class="page-header">
    <h1>Subcategory</h1>
    <p>Product subcategories grouped under a parent category.</p>
</div>

<div class="toolbar">
    <div class="toolbar-left">
        <form method="GET">
            <input type="text" name="search" value="{{ request('search') }}"
                   class="search-input" placeholder="Search subcategory...">
        </form>
        <div class="record-badge">{{ $subcategories->count() }} records</div>
    </div>

    <a href="{{ route('subcategories.create') }}" class="btn-add">+ Add Subcategory</a>
</div>

<div class="table-wrap">
    <table class="data-table">
        <thead>
            <tr>
                <th>Subcategory Name</th>
                <th>Parent Category</th>
                <th class="actions-col">Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($subcategories as $subcategory)
                <tr>
                    <td>{{ $subcategory->name }}</td>
                    <td>{{ $subcategory->category->name ?? '—' }}</td>
                    <td class="actions-cell">
                        <a href="{{ route('subcategories.edit', $subcategory) }}" class="icon-btn edit" title="Edit">
                            <svg fill="none" stroke="#4f46e5" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931z"/>
                            </svg>
                        </a>
                        <form action="{{ route('subcategories.destroy', $subcategory) }}" method="POST"
                              style="display:inline;"
                              onsubmit="return confirm('Delete this subcategory?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="icon-btn delete" title="Delete">
                                <svg fill="none" stroke="#dc2626" stroke-width="2" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397M4.772 5.79c.34-.059.68-.114 1.022-.166m0 0a47.66 47.66 0 013.478-.397m7.5 0V4.5a2.25 2.25 0 00-2.25-2.25h-3a2.25 2.25 0 00-2.25 2.25v.75m7.5 0h-7.5"/>
                                </svg>
                            </button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="3" class="empty-row">No subcategories found.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>

@endsection
