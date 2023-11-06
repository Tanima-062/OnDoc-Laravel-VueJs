<?php

namespace App\Http\Requests\MobileAppUser;

use App\Models\CompanyUser;
use App\Models\MobileAppUser;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreRequest extends FormRequest
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
            'email'                     =>  ['required', 'email:filter'],
            'first_name'                =>  ['required', 'regex:/^[\p{L}\p{M}\p{Zs}\-]+$/u'],
            'last_name'                 =>  ['required', 'regex:/^[\p{L}\p{M}\p{Zs}\-]+$/u'],
        ];
    }

    public function withValidator($validator)
    {
        return $validator->after(function ($validator) {
            $user = MobileAppUser::where('email', $this->email)->first();
            if ($user && CompanyUser::where('mobile_app_user_id', $user->id)->where('company_id',  auth()->user()->company_id)->exists()) {
                $validator->errors()->add('email', "“{$this->email}” already registered on the system as an app user");
            }
        });
    }
}
