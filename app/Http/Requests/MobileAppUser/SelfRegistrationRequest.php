<?php

namespace App\Http\Requests\MobileAppUser;

use App\Models\MobileAppUser;
use App\Rules\UniquePhoneNumber;
use Illuminate\Foundation\Http\FormRequest;

use Propaganistas\LaravelPhone\PhoneNumber;

class SelfRegistrationRequest extends FormRequest
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
            'email'                     =>  ['required', 'unique:mobile_app_users,email'],
            'first_name'                =>  ['required','regex:/^[\p{L}\p{M}\p{Zs}\-]+$/u'],
            'last_name'                 =>  ['required','regex:/^[\p{L}\p{M}\p{Zs}\-]+$/u'],
            'street'                    =>  ['nullable',],
            'house_number'              =>  ['nullable',],
            'company'                   =>  ['required'],
            'zip_code'                  =>  ['nullable','regex:/^[0-9]+$/'],
            'city'                      =>  ['nullable',],
            'country'                   =>  ['nullable',],
            'country_iso_code'          =>  ['required','required_with:phone_number', 'max:10'],
            'phone_number'              =>  ['required',"phone:country_iso_code",],
            'language_id'               =>  ['required','exists:language,id'],
            'photo'                     =>  ['nullable', 'mimes:png,jpg', ],
            'password'                  =>  ['required'],
            'confirm_password'          =>  ['required', 'same:password'],
            'tos'                       =>  ['required']
        ];
    }

    public function messages()
    {
        return [
            'phone_number.phone'    =>  'Invalid phone number.',
            'tos.required'          =>  'This field is required'
        ];
    }


    public function withValidator($validator)
    {
        $validator->after(function($validator){
            if (MobileAppUser::where('email', $this->email)->whereNotNull('email')->exists()) {
                $validator->errors()->add('email_unique', 'Email already exists');
            }
        });
    }
}
