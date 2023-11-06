<?php

namespace App\Http\Requests\Product;

use App\Models\Product;
use Illuminate\Foundation\Http\FormRequest;

class ProductRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return $this->user()->can('create', Product::class);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'serial_number' =>  ['unique:products,serial_number'],
            'name'     => 'required',
            'technical' =>  ['nullable', 'array'],
            'technical.*.doc_type'=> ['required_with:technical.*.file',],
            'technical.*.name'=> ['required_with:technical.*.file',],
            'supplier' =>  ['nullable', 'array'],
            'supplier.*.doc_type'=> ['required_with:supplier.*.file',],
            'supplier.*.name'=> ['required_with:supplier.*.file',],
            'drawing' =>  ['nullable', 'array'],
            'drawing.*.doc_type'=> ['required_with:drawing.*.file',],
            'drawing.*.name'=> ['required_with:drawing.*.file',],
            'instruction' =>  ['nullable', 'array'],
            'instruction.*.doc_type'=> ['required_with:instruction.*.file',],
            'instruction.*.name'=> ['required_with:instruction.*.file',],
            'modification_guide' =>  ['nullable', 'array'],
            'modification_guide.*.doc_type'=> ['required_with:modification_guide.*.file',],
            'modification_guide.*.name'=> ['required_with:modification_guide.*.file',],
        ];
    }

    public function withValidator($validator)
    {
        $validator->after(function ($validator) {
            if ($this->technical) {
                foreach ($this->technical as $key => $value) {
                    if (isset($value['file']) && !isset($value['doc_type'])) {
                        $validator->errors()->add("technical." .$key. ".doc_type", 'Type is required with file');
                    }
                    if (isset($value['file']) && !isset($value['name'])) {
                        $validator->errors()->add("technical." .$key. ".name", 'Name is required with file');
                    }
                }
            }
            if ($this->supplier) {
                foreach ($this->supplier as $key => $value) {
                    if (isset($value['file']) && !isset($value['doc_type'])) {
                        $validator->errors()->add("supplier." .$key. ".doc_type", 'Type is required with file');
                    }
                    if (isset($value['file']) && !isset($value['name'])) {
                        $validator->errors()->add("supplier." .$key. ".name", 'Name is required with file');
                    }
                }
            }
            if ($this->drawing) {
                foreach ($this->drawing as $key => $value) {
                    if (isset($value['file']) && !isset($value['doc_type'])) {
                        $validator->errors()->add("drawing." .$key. ".doc_type", 'Type is required with file');
                    }
                    if (isset($value['file']) && !isset($value['name'])) {
                        $validator->errors()->add("drawing." .$key. ".name", 'Name is required with file');
                    }
                }
            }
            if ($this->instruction) {
                foreach ($this->instruction as $key => $value) {
                    if (isset($value['file']) && !isset($value['doc_type'])) {
                        $validator->errors()->add("instruction." .$key. ".doc_type", 'Type is required with file');
                    }
                    if (isset($value['file']) && !isset($value['name'])) {
                        $validator->errors()->add("instruction." .$key. ".name", 'Name is required with file');
                    }
                }
            }
            if ($this->modification_guide) {
                foreach ($this->modification_guide as $key => $value) {
                    if (isset($value['file']) && !isset($value['doc_type'])) {
                        $validator->errors()->add("modification_guide." .$key. ".doc_type", 'Type is required with file');
                    }
                    if (isset($value['file']) && !isset($value['name'])) {
                        $validator->errors()->add("modification_guide." .$key. ".name", 'Name is required with file');
                    }
                }
            }
        });
    }
}
