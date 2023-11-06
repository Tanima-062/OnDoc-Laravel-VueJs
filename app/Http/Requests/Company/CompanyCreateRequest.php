<?php

namespace App\Http\Requests\Company;

use Illuminate\Foundation\Http\FormRequest;

class CompanyCreateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
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
            'name'                          =>  ['required', 'max:40','unique:companies,name', ],
            'logo'                          =>  ['nullable', 'max:5120','mimes:png,jpg', ],
            'street'                        =>  ['required', 'max:20'],
            'house_number'                  =>  ['required', 'max:20'],
            'postal_code'                   =>  ['required', 'max:4'],
            'city'                          =>  ['required', 'max:20'],
            'country_code'                  =>  ['required', ],
            'contact_persion_first_name'    =>  ['required', 'max:40',],
            'contact_persion_last_name'     =>  ['required', 'max:40',],
            'contact_persion_last_name'     =>  ['required', 'max:40',],
            'contact_persion_email'         =>  ['required', ],
            'country_iso_code'              =>  ['required', ],
            'phone_number'                  =>  ['required', ],

        ];
    }
}
