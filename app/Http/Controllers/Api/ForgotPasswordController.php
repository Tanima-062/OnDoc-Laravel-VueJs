<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Models\MobileAppUser;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Validation\Rules\Password;
use App\Notifications\MobileAppUserForgotPasswordNotification;

class ForgotPasswordController extends Controller
{

    public function sendPasswordResetOtp(Request $request)
    {
        $request->validate([
            'email'  =>  ['required']
        ]);

        $user = MobileAppUser::active()->where('email', $request->email)->firstOrFail();

        $token = mt_rand(10000, 99999);
        DB::table('mobile_password_resets')->updateOrInsert(
            ['mobile_app_user_id' => $user->id, 'username' => $request->email],
            [
                'token'     =>   $token,
                'created_at'    =>  now(),
                'updated_at'    =>  now(),
            ]
        );

        $user->notify(new MobileAppUserForgotPasswordNotification($request->email, $token));
        return response(['message' => 'Thank you very much. The email was sent successfully.', 'status' => true]);
    }


    /**
     * Verify forgot pasword OTP
     *
     * @param Request $request
     * @return void
     */
    public function verifyOtp(Request $request)
    {
        $request->validate([
            'email'     =>  ['required', 'email'],
            'otp'       =>  ['required']
        ]);

        $token = DB::table('mobile_password_resets')
            ->where('token', $request->otp)
            ->where('username', $request->email)
            ->exists();

        if (!$token) {
            return response(['status' => false], 422);
        }

        return response(['status' => true], 200);
    }

    /**
     * Update password by forgot password
     *
     * @param Request $request
     * @return void
     */
    public function updatePassword(Request $request)
    {
        $request->validate([
            'otp'         =>  ['required'],
            'email'      =>  ['required',],
            'password'      =>  ['required', Password::min(8)->mixedCase()->numbers()->symbols()],
            'confirm_password'      =>  ['required', 'same:password'],
        ]);

        if ($user_password_reset = DB::table('mobile_password_resets')->where(['token' => $request->otp, 'username' => $request->email])->first()) {
            $user = MobileAppUser::where('id', $user_password_reset->mobile_app_user_id)->first();

            $user->update(['password' => bcrypt($request->password)]);
            return response(['message' => 'Password update has been successfully', 'data' => $user, 'status' => true], 200);
        }

        return response(['message' => 'Invalid otp', 'status' => false], 404);
    }
}
