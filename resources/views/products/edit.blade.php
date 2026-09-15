@extends('layouts.app')

@push('styles')
<style>
    .modal-page-wrap { display: flex; justify-content: center; padding-top: 24px; }
    .modal-card { background: #fff; border-radius: 14px; box-shadow: 0 10px 30px rgba(0,0,0,0.08); width: 100%; max-width: 960px; overflow: hidden; }
    .modal-card-header { display: flex; align-items: center; justify-content: space-between; padding: 24px 28px; border-bottom: 1px solid #edebf3; }
    .modal-header-left { display: flex; align-items: center; gap: 14px; }
    .modal-icon-badge { width: 44px; height: 44px; border-radius: 10px; background: #155DFC; display: flex; align-items: center; justify-content: center; flex-shrink: 0; }
    .modal-icon-badge svg { width: 20px; height: 20px; stroke: #1f2937; }
    .modal-eyebrow { font-size: 12px; font-weight: 700; letter-spacing: 0.05em; color: #155DFC; margin: 0 0 2px; text-transform: uppercase; }
    .modal-title { font-size: 22px; font-weight: 800; color: #111827; margin: 0; }
    .btn-back { display: inline-flex; align-items: center; gap: 8px; background: #fff; border: 1px solid #e5e7eb; border-radius: 8px; padding: 9px 16px; font-size: 14px; font-weight: 600; color: #374151; text-decoration: none; }
    .btn-back:hover { background: #f9fafb; }
    .btn-back svg { width: 14px; height: 14px; }
    .modal-body { padding: 28px; display: flex; flex-direction: column; gap: 24px; }
    .type-toggle { display: flex; gap: 12px; }
    .type-btn { flex: 1; padding: 12px; border: 2px solid #e5e7eb; border-radius: 10px; background: #fff; font-size: 14px; font-weight: 600; color: #6b7280; cursor: pointer; transition: all 0.15s; text-align: center; }
    .type-btn.active { border-color: #155DFC; background: #fffbf0; color: #92400e; }
    .fields-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 20px; }
    .form-group label { display: block; font-size: 13px; font-weight: 600; color: #374151; margin-bottom: 8px; }
    .form-group input, .form-group select { width: 100%; border: 1px solid #d1d5db; border-radius: 8px; padding: 10px 14px; font-size: 14px; box-sizing: border-box; background: #fff; }
    .form-group input:focus, .form-group select:focus { outline: none; border-color: #155DFC; box-shadow: 0 0 0 3px rgba(245,165,36,0.15); }
    .form-group input.is-invalid, .form-group select.is-invalid { border-color: #f87171; }
    .error-text { color: #ef4444; font-size: 12px; margin-top: 6px; }
    .section-title { font-size: 15px; font-weight: 700; color: #111827; margin: 0 0 16px; padding-bottom: 10px; border-bottom: 1px solid #f3f4f6; }
    .item-card { background: #f9fafb; border: 1px solid #e5e7eb; border-radius: 10px; padding: 20px; }
    .item-card + .item-card { margin-top: 12px; }
    .item-card-header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 16px; }
    .item-label { font-size: 13px; font-weight: 700; color: #374151; }
    .btn-remove-item { background: #fef2f2; border: 1px solid #fecaca; color: #dc2626; border-radius: 6px; padding: 4px 10px; font-size: 12px; font-weight: 600; cursor: pointer; }
    .btn-remove-item:hover { background: #fee2e2; }
    .btn-add-item { display: inline-flex; align-items: center; gap: 8px; background: #fff; border: 1px dashed #d1d5db; border-radius: 8px; padding: 10px 18px; font-size: 14px; font-weight: 600; color: #6b7280; cursor: pointer; margin-top: 12px; }
    .btn-add-item:hover { border-color: #155DFC; color: #92400e; background: #fffbf0; }
    .modal-footer { display: flex; justify-content: flex-end; gap: 12px; padding: 20px 28px; border-top: 1px solid #edebf3; }
    .btn-secondary { background: #fff; color: #374151; border: 1px solid #d1d5db; padding: 10px 22px; border-radius: 8px; font-size: 14px; font-weight: 600; text-decoration: none; }
    .btn-secondary:hover { background: #f9fafb; }
    .btn-save { background: #2B7FFF; color: #fff; border: none; padding: 10px 24px; border-radius: 8px; font-size: 14px; font-weight: 700; cursor: pointer; }
    .btn-save:hover { background: oklch(54.6% 0.245 262.881); }
    .upload-group label.field-label { display: flex; align-items: center; gap: 5px; }
    .help-icon { display: inline-flex; align-items: center; justify-content: center; width: 15px; height: 15px; border-radius: 50%; border: 1px solid #9ca3af; color: #9ca3af; font-size: 10px; cursor: help; flex-shrink: 0; }
    .upload-dropzone { width: 140px; height: 110px; border: 2px dashed #d1d5db; border-radius: 10px; display: flex !important; flex-direction: column; align-items: center; justify-content: center; background: #fafafa; cursor: pointer; color: #6b7280; transition: all 0.15s; text-align: center; overflow: hidden; box-sizing: border-box; }
    .upload-dropzone:hover { border-color: #155DFC; background: #fffbf0; color: #92400e; }
    .upload-dropzone .upload-plus { font-size: 22px; font-weight: 300; line-height: 1; margin-bottom: 6px; }
    .upload-dropzone .upload-text { font-size: 13px; font-weight: 500; }
    .upload-dropzone img.upload-preview { width: 100%; height: 100%; object-fit: cover; }
    .upload-input-hidden { display: none; }
</style>
@endpush

@section('content')
@php $currentType = old('type', $product->type); @endphp
<div class="modal-page-wrap">
    <div class="modal-card">
        <div class="modal-card-header">
            <div class="modal-header-left">
                <div class="modal-icon-badge">
                    <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M20 7H4a2 2 0 00-2 2v10a2 2 0 002 2h16a2 2 0 002-2V9a2 2 0 00-2-2z"/><path stroke-linecap="round" stroke-linejoin="round" d="M16 3H8a2 2 0 00-2 2v2h12V5a2 2 0 00-2-2z"/></svg>
                </div>
                <div>
                    <p class="modal-eyebrow">Editing Record</p>
                    <h1 class="modal-title">Edit — Product</h1>
                </div>
            </div>
            <a href="{{ route('products.index') }}" class="btn-back">
                <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
                Back
            </a>
        </div>

        <form method="POST" action="{{ route('products.update', $product) }}" enctype="multipart/form-data">
            @csrf @method('PUT')
            <input type="hidden" name="type" id="type-input" value="{{ $currentType }}">

            <div class="modal-body">

                {{-- Type Toggle --}}
                <div>
                    <p class="section-title">Product Type</p>
                    <div class="type-toggle">
                        <button type="button" class="type-btn {{ $currentType === 'accessory' ? 'active' : '' }}" onclick="setType('accessory')">🔌 Accessory</button>
                        <button type="button" class="type-btn {{ $currentType === 'mobile' ? 'active' : '' }}" onclick="setType('mobile')">📱 Mobile</button>
                    </div>
                </div>

                {{-- Product Info --}}
                <div>
                    <p class="section-title">Product Info</p>
                    <div class="fields-grid">
                        <div class="form-group">
                            <label>Vendor Name</label>
                            <select name="vendor_id" class="{{ $errors->has('vendor_id') ? 'is-invalid' : '' }}">
                                <option value="">— Select Vendor —</option>
                                @foreach ($vendors as $vendor)
                                    <option value="{{ $vendor->id }}" {{ old('vendor_id', $product->vendor_id) == $vendor->id ? 'selected' : '' }}>{{ $vendor->name }}</option>
                                @endforeach
                            </select>
                            @error('vendor_id')<div class="error-text">{{ $message }}</div>@enderror
                        </div>
                        <div class="form-group">
                            <label>Category</label>
                            <select name="category_id" class="{{ $errors->has('category_id') ? 'is-invalid' : '' }}">
                                <option value="">— Select Category —</option>
                                @foreach ($categories as $category)
                                    <option value="{{ $category->id }}" {{ old('category_id', $product->category_id) == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                                @endforeach
                            </select>
                            @error('category_id')<div class="error-text">{{ $message }}</div>@enderror
                        </div>
                        <div class="form-group">
                            <label>Subcategory</label>
                            <select name="subcategory_id" class="{{ $errors->has('subcategory_id') ? 'is-invalid' : '' }}">
                                <option value="">— Select Subcategory —</option>
                                @foreach ($subcategories as $sub)
                                    <option value="{{ $sub->id }}" {{ old('subcategory_id', $product->subcategory_id) == $sub->id ? 'selected' : '' }}>{{ $sub->name }}</option>
                                @endforeach
                            </select>
                            @error('subcategory_id')<div class="error-text">{{ $message }}</div>@enderror
                        </div>
                        <div class="form-group">
                            <label>Quantity</label>
                            <input type="number" name="quantity" value="{{ old('quantity', $product->quantity) }}" min="1" class="{{ $errors->has('quantity') ? 'is-invalid' : '' }}">
                            @error('quantity')<div class="error-text">{{ $message }}</div>@enderror
                        </div>
                        <div class="form-group">
                            <label>Total Purchase Amount</label>
                            <input type="number" name="total_purchase_amount" value="{{ old('total_purchase_amount', $product->total_purchase_amount) }}" step="0.01" min="0" class="{{ $errors->has('total_purchase_amount') ? 'is-invalid' : '' }}">
                            @error('total_purchase_amount')<div class="error-text">{{ $message }}</div>@enderror
                        </div>
                    </div>
                </div>

                {{-- Item Cards --}}
                <div>
                    <p class="section-title" id="items-section-title">
                        {{ $currentType === 'mobile' ? 'Product Details' : 'Accessory Details' }}
                    </p>

                    <div id="items-container">
                        @php $existingItems = old('items') ? collect(old('items'))->map(fn($i) => (object)$i) : $product->items; @endphp
                        @foreach ($existingItems as $i => $item)
                            <div class="item-card">
                                <div class="item-card-header">
                                    <span class="item-label">Detail #<span class="item-num">{{ $i + 1 }}</span></span>
                                    @if ($i > 0)
                                        <button type="button" class="btn-remove-item" onclick="removeItem(this)">Remove</button>
                                    @endif
                                </div>
                                <div class="fields-grid">

                                    {{-- Accessory fields --}}
                                    <div class="form-group accessory-fields" style="{{ $currentType === 'mobile' ? 'display:none' : '' }}">
                                        <label>Purchase Price</label>
                                        <input type="number" name="items[{{ $i }}][purchase_price]" value="{{ old("items.{$i}.purchase_price", $item->purchase_price ?? '') }}" step="0.01" min="0">
                                    </div>
                                    <div class="form-group accessory-fields" style="{{ $currentType === 'mobile' ? 'display:none' : '' }}">
                                        <label>Sell Price</label>
                                        <input type="number" name="items[{{ $i }}][sell_price]" value="{{ old("items.{$i}.sell_price", $item->sell_price ?? '') }}" step="0.01" min="0">
                                    </div>

                                    {{-- Mobile fields --}}
                                    <div class="form-group mobile-fields" style="{{ $currentType !== 'mobile' ? 'display:none' : '' }}">
                                        <label>Brand</label>
                                        <input type="text" name="items[{{ $i }}][brand]" value="{{ old("items.{$i}.brand", $item->brand ?? '') }}">
                                    </div>
                                    <div class="form-group mobile-fields" style="{{ $currentType !== 'mobile' ? 'display:none' : '' }}">
                                        <label>Model</label>
                                        <input type="text" name="items[{{ $i }}][model]" value="{{ old("items.{$i}.model", $item->model ?? '') }}">
                                    </div>
                                    <div class="form-group mobile-fields" style="{{ $currentType !== 'mobile' ? 'display:none' : '' }}">
                                        <label>IMEI</label>
                                        <input type="text" name="items[{{ $i }}][imei]" value="{{ old("items.{$i}.imei", $item->imei ?? '') }}">
                                    </div>
                                    <div class="form-group mobile-fields" style="{{ $currentType !== 'mobile' ? 'display:none' : '' }}">
                                        <label>Serial Number</label>
                                        <input type="text" name="items[{{ $i }}][serial_number]" value="{{ old("items.{$i}.serial_number", $item->serial_number ?? '') }}">
                                    </div>
                                    <div class="form-group mobile-fields" style="{{ $currentType !== 'mobile' ? 'display:none' : '' }}">
                                        <label>Warranty Period</label>
                                        <input type="text" name="items[{{ $i }}][warranty_period]" value="{{ old("items.{$i}.warranty_period", $item->warranty_period ?? '') }}" placeholder="e.g. 1 Year">
                                    </div>
                                    <div class="form-group mobile-fields" style="{{ $currentType !== 'mobile' ? 'display:none' : '' }}">
                                        <label>Reg. Status</label>
                                        <select name="items[{{ $i }}][reg_status]">
                                            <option value="">— Select —</option>
                                            <option value="PTA" {{ old("items.{$i}.reg_status", $item->reg_status ?? '') === 'PTA' ? 'selected' : '' }}>PTA</option>
                                            <option value="Non PTA" {{ old("items.{$i}.reg_status", $item->reg_status ?? '') === 'Non PTA' ? 'selected' : '' }}>Non PTA</option>
                                        </select>
                                    </div>
                                    <div class="form-group mobile-fields" style="{{ $currentType !== 'mobile' ? 'display:none' : '' }}">
                                        <label>Branch</label>
                                        <select name="items[{{ $i }}][branch_id]">
                                            <option value="">— Select Branch —</option>
                                            @foreach ($branches as $branch)
                                                <option value="{{ $branch->id }}" {{ old("items.{$i}.branch_id", $item->branch_id ?? '') == $branch->id ? 'selected' : '' }}>{{ $branch->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="form-group mobile-fields" style="{{ $currentType !== 'mobile' ? 'display:none' : '' }}">
                                        <label>Purchase Amount</label>
                                        <input type="number" name="items[{{ $i }}][purchase_amount]" value="{{ old("items.{$i}.purchase_amount", $item->purchase_amount ?? '') }}" step="0.01" min="0">
                                    </div>

                                    {{-- Shared image --}}
                                    <div class="form-group upload-group">
                                        <label class="field-label">Image <span class="help-icon" title="Upload product image">?</span></label>
                                        <label for="item-image-{{ $i }}" class="upload-dropzone" id="item-dropzone-{{ $i }}">
                                            @if (!empty($item->image))
                                                <img src="{{ Storage::url($item->image) }}" class="upload-preview">
                                            @else
                                                <div class="upload-plus">+</div>
                                                <div class="upload-text">Upload</div>
                                            @endif
                                        </label>
                                        <input type="file" id="item-image-{{ $i }}" name="items[{{ $i }}][image]" accept="image/*"
                                            class="upload-input-hidden"
                                            onchange="previewImage(this, 'item-dropzone-{{ $i }}')">
                                    </div>

                                </div>
                            </div>
                        @endforeach
                    </div>

                    <button type="button" class="btn-add-item" onclick="addItem()">+ Add Product</button>
                </div>

            </div>

            <div class="modal-footer">
                <a href="{{ route('products.index') }}" class="btn-secondary">Cancel</a>
                <button type="submit" class="btn-save">Save Changes</button>
            </div>
        </form>
    </div>
</div>

<script>
    let itemCount = {{ $existingItems->count() }};
    let currentType = '{{ $currentType }}';

    const branches = @json($branches->map(fn($b) => ['id' => $b->id, 'name' => $b->name]));

    function setType(type) {
        currentType = type;
        document.getElementById('type-input').value = type;
        document.querySelectorAll('.type-btn').forEach(b => b.classList.remove('active'));
        event.currentTarget.classList.add('active');
        document.getElementById('items-section-title').textContent = type === 'mobile' ? 'Product Details' : 'Accessory Details';
        document.querySelectorAll('.accessory-fields').forEach(el => el.style.display = type === 'accessory' ? '' : 'none');
        document.querySelectorAll('.mobile-fields').forEach(el => el.style.display = type === 'mobile' ? '' : 'none');
    }

    function addItem() {
        const container = document.getElementById('items-container');
        const idx = itemCount++;

        let branchOptions = '<option value="">— Select Branch —</option>';
        branches.forEach(b => branchOptions += `<option value="${b.id}">${b.name}</option>`);

        const accStyle = currentType === 'accessory' ? '' : 'display:none';
        const mobStyle = currentType === 'mobile'    ? '' : 'display:none';

        const card = document.createElement('div');
        card.className = 'item-card';
        card.style.marginTop = '12px';
        card.innerHTML = `
            <div class="item-card-header">
                <span class="item-label">Detail #<span class="item-num">${idx + 1}</span></span>
                <button type="button" class="btn-remove-item" onclick="removeItem(this)">Remove</button>
            </div>
            <div class="fields-grid">
                <div class="form-group accessory-fields" style="${accStyle}">
                    <label>Purchase Price</label>
                    <input type="number" name="items[${idx}][purchase_price]" step="0.01" min="0">
                </div>
                <div class="form-group accessory-fields" style="${accStyle}">
                    <label>Sell Price</label>
                    <input type="number" name="items[${idx}][sell_price]" step="0.01" min="0">
                </div>
                <div class="form-group mobile-fields" style="${mobStyle}">
                    <label>Brand</label><input type="text" name="items[${idx}][brand]">
                </div>
                <div class="form-group mobile-fields" style="${mobStyle}">
                    <label>Model</label><input type="text" name="items[${idx}][model]">
                </div>
                <div class="form-group mobile-fields" style="${mobStyle}">
                    <label>IMEI</label><input type="text" name="items[${idx}][imei]">
                </div>
                <div class="form-group mobile-fields" style="${mobStyle}">
                    <label>Serial Number</label><input type="text" name="items[${idx}][serial_number]">
                </div>
                <div class="form-group mobile-fields" style="${mobStyle}">
                    <label>Warranty Period</label><input type="text" name="items[${idx}][warranty_period]" placeholder="e.g. 1 Year">
                </div>
                <div class="form-group mobile-fields" style="${mobStyle}">
                    <label>Reg. Status</label>
                    <select name="items[${idx}][reg_status]">
                        <option value="">— Select —</option>
                        <option value="PTA">PTA</option>
                        <option value="Non PTA">Non PTA</option>
                    </select>
                </div>
                <div class="form-group mobile-fields" style="${mobStyle}">
                    <label>Branch</label>
                    <select name="items[${idx}][branch_id]">${branchOptions}</select>
                </div>
                <div class="form-group mobile-fields" style="${mobStyle}">
                    <label>Purchase Amount</label>
                    <input type="number" name="items[${idx}][purchase_amount]" step="0.01" min="0">
                </div>
                <div class="form-group upload-group">
                    <label class="field-label">Image <span class="help-icon" title="Upload product image">?</span></label>
                    <label for="item-image-${idx}" class="upload-dropzone" id="item-dropzone-${idx}">
                        <div class="upload-plus">+</div>
                        <div class="upload-text">Upload</div>
                    </label>
                    <input type="file" id="item-image-${idx}" name="items[${idx}][image]" accept="image/*"
                        class="upload-input-hidden"
                        onchange="previewImage(this, 'item-dropzone-${idx}')">
                </div>
            </div>`;
        container.appendChild(card);
        renumberItems();
    }

    function removeItem(btn) {
        btn.closest('.item-card').remove();
        renumberItems();
    }

    function renumberItems() {
        document.querySelectorAll('#items-container .item-card').forEach((card, i) => {
            card.querySelector('.item-num').textContent = i + 1;
        });
    }

    function previewImage(input, dropzoneId) {
        const dropzone = document.getElementById(dropzoneId);
        if (!input.files[0]) return;
        const reader = new FileReader();
        reader.onload = e => dropzone.innerHTML = `<img src="${e.target.result}" class="upload-preview">`;
        reader.readAsDataURL(input.files[0]);
    }
</script>
@endsection
