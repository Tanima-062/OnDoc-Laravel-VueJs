<?php

namespace App\Http\Controllers\Api;

use App\Traits\UploadAble;
use App\Models\SalesPartner;
use Illuminate\Http\Request;
use App\Models\MobileAppUser;
use App\Rules\MatchSamePassword;
use App\Http\Controllers\Controller;
use Illuminate\Validation\Rules\Password;
use Symfony\Component\HttpFoundation\Response;
use App\Http\Resources\MobileAppUser\MobileAppUserResource;
use App\Http\Requests\MobileAppUser\SelfRegistrationRequest;
use App\Notifications\MobileAppUser\MobileAppUserRegistrationNotification;

class RegistrationController extends Controller
{
    use UploadAble;
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(SelfRegistrationRequest $request)
    {
        $data = $request->only(['email', 'first_name', 'last_name', 'company_id', 'tos','street', 'password', 'zip_code', 'city', 'country', 'country_iso_code', 'language_id', 'phone_number']);

        $user = MobileAppUser::create($data + ['status'=> MobileAppUser::STATUS_PENDING]);

        return response()->json(['status' => true], Response::HTTP_CREATED);
    }





    /**
     * Check username and email exists
     *
     * @param Request $request
     * @return void
     */
    public function checkUser(Request $request)
    {
        $request->validate([
            'column'     =>  ['required', 'in:username,email'],
            'value'     =>  ['required']
        ]);

        $user = MobileAppUser::where($request->column, $request->value)->first();

        if ($user) {
            return response(['status' => true, 'is_active'=>  $user->status == 'active' ], 200);
        }

        return response(['status' => false, 'is_active'=>false], 200);
    }




    /**
     * Verify User OTP
     *
     * @param Request $request
     * @return void
     */
    public function verifyOtp(Request $request)
    {
        $request->validate([
            'email'     =>  ['required', 'email',],
            'otp'       =>  ['required']
        ]);

        $user  = MobileAppUser::where('email', $request->email)
            ->where('verification_token', $request->otp)
            ->first();

        if(!$user){
            return response(['status' => false], 200);
        }

        return response(['status' => true], 200);
    }


    /**
     * Resend Registration OTP
     *
     * @param Request $request
     * @return void
     */
    public function resendOtp(Request $request)
    {
        $request->validate([
            'email'     =>  ['required', 'exists:mobile_app_users,email']
        ]);

        $mobile_app_user = MobileAppUser::where('email', $request->email)
            ->where('status', MobileAppUser::STATUS_PENDING)
            ->first();

        if(!$mobile_app_user){
            return response([
                'status'    =>  false,
            ], Response::HTTP_NOT_FOUND);
        }

        $token = mt_rand(100000,999999);

        $mobile_app_user->update([
            'verification_token'    =>  $token
        ]);

        $mobile_app_user->notify(new MobileAppUserRegistrationNotification($token));

        return response([
            'status'    =>  true,
        ], Response::HTTP_OK);
    }
}
