<?php

namespace App\Http\Requests\MobileAppUser;

use App\Models\EmailVerification;
use App\Models\MobileAppUser;
use App\Rules\UniquePhoneNumber;
use App\Rules\ValidBase64Image;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Hash;
use Propaganistas\LaravelPhone\PhoneNumber;

class UpdateProfileRequest extends FormRequest
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
        $user = request()->user();
        return [
            'first_name'                =>  ['required', 'regex:/^[\p{L}\p{M}\p{Zs}-]+$/u'],
            'last_name'                 =>  ['required', 'regex:/^[\p{L}\p{M}\p{Zs}-]+$/u'],
            'photo'                     =>  ['nullable', 'string', new ValidBase64Image(['image/jpeg', 'image/jpg', 'image/png', 'image/webp'])],
            'street'                    =>  ['nullable', 'string'],
            'house_number'              =>  ['nullable', 'string'],
            'zip_code'                  =>  ['nullable', 'regex:/^[0-9]+$/'],
            'city'                      =>  ['nullable', 'string'],
            'company'                   =>  ['nullable', 'string', 'max:30'],
            'country_iso_code'          =>  ['required', 'max:10'],
            'phone_number'              =>  ["required", "phone:country_iso_code",],
            'email'                     =>  ['required', "email:filter", 'unique:mobile_app_users,email,' . $user->id],
            'language_id'               =>  ['nullable', 'exists:language,id'],
        ];
    }

    public function withValidator($validator)
    {
        $validator->after(function ($validator) {
            $user = $this->user();
            if ($this->current_password && !Hash::check($this->current_password, $user->password)) {
                $validator->errors()->add('current_password', "Invalid password provided");
            }

            if ($this->otp) {
                if (!EmailVerification::where(['token' => $this->otp, 'mobile_app_user_id' => $user->id, 'email' => $this->email])->exists()) {
                    $validator->errors()->add('otp', 'Invalid otp provided');
                } else {
                    EmailVerification::where(['token' => $this->otp, 'mobile_app_user_id' => $user->id, 'email' => $this->email])->delete();
                    $user->tokens()->delete();
                }
            }
        });
    }

    public function messages()
    {
        return [
            'phone_number.phone'    =>  'Invalid phone number.',
        ];
    }
}
