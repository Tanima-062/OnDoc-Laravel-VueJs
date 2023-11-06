<?php

namespace App\Http\Requests\Category;

use App\Models\Category;
use Illuminate\Foundation\Http\FormRequest;

class CreateCategoryRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return $this->user()->can('create', Category::class);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'name'      =>  ['required', 'unique:categories,name,null,id,company_id,'.auth()->user()->company_id ],
        ];
    }

    public function messages()
    {
        return [
            // 'name.unique'   =>  'Category “:name” already exist',
            'name.unique'   =>  trans('Category “:name” already exist', ['name'=>$this->name], auth()->user()->language->code)
        ];
    }
}
