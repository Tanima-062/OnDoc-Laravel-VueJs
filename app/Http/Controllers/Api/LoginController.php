<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use Illuminate\Http\Request;
use App\Models\MobileAppUser;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Foundation\Auth\ThrottlesLogins;
use App\Http\Resources\MobileAppUser\MobileAppUserResource;
use App\Models\CompanyUser;

class LoginController extends Controller
{
    use ThrottlesLogins, HasApiTokens;
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request)
    {
        if ($this->hasTooManyLoginAttempts($request)) {
            $this->fireLockoutEvent($request);
            return $this->sendLockoutResponse($request);
        }

        $request->validate([
            // 'email'      =>  ['required',"exists:mobile_app_users,email,company_id,1"],
            'email'      =>  ['required',],

            'password'   =>  ['required'],
            'fcm_token'  =>  'nullable'
        ]);

        $credentials = [
            'email' => $request->email,
        ];

        if ($user =  MobileAppUser::where($credentials)->first()) {
            if (!Hash::check($request->password, $user->password)) {
                $this->incrementLoginAttempts($request);
                return response()->json(['error' => 'Unauthenticated'], 401);
            }

            $this->clearLoginAttempts($request);

            return response()->json(
                array(
                    'data' => [
                        'token' => [
                            'access_token' => $user->createToken('authToken')->plainTextToken,
                            'token_type' => 'bearer',
                        ],
                    ],
                    // 'user' => $user,
                    'user'  =>  new MobileAppUserResource($user)
                )
            );
        } else {
            $this->incrementLoginAttempts($request);
        }
        throw new AuthenticationException();
    }

    public function username()
    {
        return  'email';
    }


    /**
     * Get the guard to be used during authentication.
     *
     * @return \Illuminate\Contracts\Auth\Guard
     */
    public function guard()
    {
        return Auth::guard('appusers');
    }
}
