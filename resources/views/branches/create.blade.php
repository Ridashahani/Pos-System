@extends('layouts.app')

@push('styles')
<style>
    .modal-page-wrap { display: flex; justify-content: center; padding-top: 24px; }
    .modal-card { background: #fff; border-radius: 14px; box-shadow: 0 10px 30px rgba(0,0,0,0.08); width: 100%; max-width: 900px; overflow: hidden; }
    .modal-card-header { display: flex; align-items: center; justify-content: space-between; padding: 24px 28px; border-bottom: 1px solid #edebf3; }
    .modal-header-left { display: flex; align-items: center; gap: 14px; }
    .modal-icon-badge { width: 44px; height: 44px; border-radius: 10px; background: #f5a524; display: flex; align-items: center; justify-content: center; flex-shrink: 0; }
    .modal-icon-badge svg { width: 20px; height: 20px; stroke: #1f2937; }
    .modal-eyebrow { font-size: 12px; font-weight: 700; letter-spacing: 0.05em; color: #f5a524; margin: 0 0 2px; text-transform: uppercase; }
    .modal-title { font-size: 22px; font-weight: 800; color: #111827; margin: 0; }
    .btn-back { display: inline-flex; align-items: center; gap: 8px; background: #fff; border: 1px solid #e5e7eb; border-radius: 8px; padding: 9px 16px; font-size: 14px; font-weight: 600; color: #374151; text-decoration: none; }
    .btn-back:hover { background: #f9fafb; }
    .btn-back svg { width: 14px; height: 14px; }
    .modal-body { padding: 28px; }
    .form-group { margin-bottom: 0; max-width: 420px; }
    .form-group label { display: block; font-size: 13px; font-weight: 600; color: #374151; margin-bottom: 8px; }
    .form-group input { width: 100%; border: 1px solid #d1d5db; border-radius: 8px; padding: 10px 14px; font-size: 14px; box-sizing: border-box; }
    .form-group input:focus { outline: none; border-color: #f5a524; box-shadow: 0 0 0 3px rgba(245,165,36,0.15); }
    .form-group input.is-invalid { border-color: #f87171; }
    .error-text { color: #ef4444; font-size: 12px; margin-top: 6px; }
    .modal-footer { display: flex; justify-content: flex-end; gap: 12px; padding: 20px 28px; border-top: 1px solid #edebf3; }
    .btn-secondary { background: #fff; color: #374151; border: 1px solid #d1d5db; padding: 10px 22px; border-radius: 8px; font-size: 14px; font-weight: 600; text-decoration: none; }
    .btn-secondary:hover { background: #f9fafb; }
    .btn-save { background: #f5a524; color: #1f2937; border: none; padding: 10px 24px; border-radius: 8px; font-size: 14px; font-weight: 700; cursor: pointer; }
    .btn-save:hover { background: #e6980f; }
</style>
@endpush

@section('content')
<div class="modal-page-wrap">
    <div class="modal-card">
        <div class="modal-card-header">
            <div class="modal-header-left">
                <div class="modal-icon-badge">
                    <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M3 9l9-7 9 7v11a2 2 0 01-2 2H5a2 2 0 01-2-2z"/><polyline points="9 22 9 12 15 12 15 22"/></svg>
                </div>
                <div>
                    <p class="modal-eyebrow">New Record</p>
                    <h1 class="modal-title">Add — Branch</h1>
                </div>
            </div>
            <a href="{{ route('branches.index') }}" class="btn-back">
                <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
                Back
            </a>
        </div>
        <form method="POST" action="{{ route('branches.store') }}">
            @csrf
            <div class="modal-body">
                <div class="form-group">
                    <label for="name">Branch Name</label>
                    <input type="text" id="name" name="name" value="{{ old('name') }}" class="{{ $errors->has('name') ? 'is-invalid' : '' }}" autofocus>
                    @error('name')<div class="error-text">{{ $message }}</div>@enderror
                </div>
            </div>
            <div class="modal-footer">
                <a href="{{ route('branches.index') }}" class="btn-secondary">Cancel</a>
                <button type="submit" class="btn-save">Save Record</button>
            </div>
        </form>
    </div>
</div>
@endsection
