<?php

namespace App\Http\Requests\MobileAppUser;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Password;

class ConfirmRegistraionRequest extends FormRequest
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
            'first_name'                =>  ['required', 'regex:/^[\p{L}\p{M}\p{Zs}\-]+$/u'],
            'last_name'                 =>  ['required', 'regex:/^[\p{L}\p{M}\p{Zs}\-]+$/u'],
            'company'                   =>  ['nullable', 'string', 'max:30'],
            'company_id'                =>  ['required', 'exists:company_user,company_id,status,pending,mobile_app_user_id,' . $this->appuser->id],
            'country_iso_code'          =>  ['required', 'max:10'],
            'phone_number'              =>  ['required', "phone:country_iso_code",],
            'password'                  =>  ['required', Password::min(8)->letters()->mixedCase()->numbers()->symbols()],
            'confirm_password'          =>  ['required', 'same:password'],
            'language_id'               =>  ['exists:language,id'],
            'tos'                       =>  ['required', 'accepted']
        ];
    }

    public function messages()
    {
        return [
            'password' => 'Min 8 characters with at least a letter, number and symbol',
            'confirm_password.same' => "Password doesn't match"
        ];
    }
}
