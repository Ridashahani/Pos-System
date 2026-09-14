<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PurchaseRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'products' => 'required|array|min:1',

            // 'products.*.product_id' => [ 'required', 'exists:products,id', ],

            'products.*.quantity' => ['required', 'numeric', 'min:1', ],

            'products.*.cost_price' => ['required','numeric','min:0',],

            'supplier_id' => ['nullable','exists:suppliers,id',],

            'new_supplier_name' => [ 'required_without:supplier_id', 'string', 'max:255',],

            'new_supplier_phone' => [ 'nullable', 'string', 'max:50',],

            'new_supplier_address' => ['nullable', 'string', 'max:255', ],

            'branch_id' => [ 'required', 'exists:branches,id',],

            'date' => [ 'required', 'date', ],

            'payment_status' => [ 'required', 'in:paid,partial,due', ],

            'amount_paid' => [ 'nullable','numeric',  'min:0', ],
        ];
    }
}
