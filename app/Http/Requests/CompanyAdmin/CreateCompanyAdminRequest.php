<?php

namespace App\Http\Requests\CompanyAdmin;

use Illuminate\Foundation\Http\FormRequest;

class CreateCompanyAdminRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        // return $this->user()->can('create');
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'first_name'            =>  ['required', 'max:40'],
            'last_name'             =>  ['required', 'max:40'],
            'email'                 =>  ['required', 'email:filter' ,'unique:users,email'],
            'company_id'            =>  ['required', 'exists:companies,id'],
        ];
    }

    public function messages()
    {
        return [
            'email.unique'      =>  'Email already registered on the system'
        ];
    }
}
