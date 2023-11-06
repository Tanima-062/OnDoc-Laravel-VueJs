<?php

namespace App\Http\Requests\Supplier;

use App\Models\Supplier;
use Illuminate\Foundation\Http\FormRequest;

class UpdateSupplierRequest extends FormRequest
{
   /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return $this->user()->can('update', $this->route('supplier'));
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'name'              =>  ['required', 'unique:suppliers,name,'.$this->supplier->id.',id,company_id,'.auth()->user()->company_id],
            "street"            =>  ['required', ],
            "house_number"      =>  ['required', ],
            "postal_code"       =>  ['required', ],
            "city"              =>  ['required', ],
            "country_code"      =>  ['required', ],
        ];
    }

    public function messages()
    {
        return [
            // 'name.unique'   =>  'Category “:name” already exist',
            'name.unique'   =>  trans('Supplier “:name” already exist', ['name'=>$this->name], auth()->user()->language->code)
        ];
    }


    /**
     * Get custom attributes for validator errors.
     *
     * @return array
     */
    public function attributes()
    {
        return [
            'country_code' => 'country',
            'city' => 'location',
        ];
    }
}
