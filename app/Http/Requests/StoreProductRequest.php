<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreProductRequest extends FormRequest
{
    public function authorize(): bool { return true; }

    public function rules(): array
    {
        $rules = [
            'type'           => ['required', 'in:accessory,mobile'],
            'vendor_id'      => ['required', 'exists:vendors,id'],
            'category_id'    => ['required', 'exists:categories,id'],
            'subcategory_id' => ['required', 'exists:subcategories,id'],
            'quantity'       => ['required', 'integer', 'min:1'],
        ];

        if ($this->type === 'accessory') {
            $rules['purchase_price'] = ['required', 'numeric', 'min:0'];
            $rules['sell_price']     = ['required', 'numeric', 'min:0'];
            $rules['image']          = ['nullable', 'image', 'max:2048'];
        } else {
            $rules['total_purchase_amount']      = ['required', 'numeric', 'min:0'];
            $rules['items']                      = ['required', 'array', 'min:1'];
            $rules['items.*.brand']              = ['required', 'string', 'max:255'];
            $rules['items.*.model']              = ['required', 'string', 'max:255'];
            $rules['items.*.imei']               = ['nullable', 'string', 'max:255'];
            $rules['items.*.serial_number']      = ['nullable', 'string', 'max:255'];
            $rules['items.*.warranty_period']    = ['nullable', 'string', 'max:255'];
            $rules['items.*.reg_status']         = ['required', 'in:PTA,Non PTA'];
            $rules['items.*.branch_id']          = ['required', 'exists:branches,id'];
            $rules['items.*.purchase_amount']    = ['required', 'numeric', 'min:0'];
            $rules['items.*.image']              = ['nullable', 'image', 'max:2048'];
        }

        return $rules;
    }
}
