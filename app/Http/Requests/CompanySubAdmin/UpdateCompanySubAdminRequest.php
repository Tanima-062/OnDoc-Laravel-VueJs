<?php

namespace App\Http\Requests\CompanySubAdmin;

use Illuminate\Foundation\Http\FormRequest;

class UpdateCompanySubAdminRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return $this->user()->can('update', $this->company_sub_admin);
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
            'email'                 =>  ['required', 'email:filter' ,'unique:users,email,'.$this->company_sub_admin->id],
            'permission'                 =>  ['required', 'in:view,full'],
        ];
    }

    public function messages()
    {
        return [
            'email.unique'      =>  'Email already registered on the system'
        ];
    }
}
