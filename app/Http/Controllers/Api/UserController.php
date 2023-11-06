<?php

namespace App\Http\Controllers\Api;

use App\Traits\UploadAble;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpFoundation\Response;
use App\Http\Requests\MobileAppUser\UpdateProfileRequest;

use App\Http\Resources\MobileAppUser\MobileAppUserResource;
use App\Mail\AppUserEmailChangeOtpMail;
use App\Models\EmailVerification;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class UserController extends Controller
{
    use UploadAble;

    /**
     * Get current authenticated user data
     *
     * @param Request $request
     * @return void
     */
    public function me(Request $request)
    {
        return response([
            'data' => [
                'user'  =>  new MobileAppUserResource($request->user())
            ],
        ]);
    }

    public function updatePassword(Request $request)
    {
        $request->validate([
            'current_password' => ['required', 'current_password:appusers'],
            'password' => ['required', Password::min(8)->letters()->mixedCase()->numbers()->symbols()],
            'password_confirmation' => ['required', 'same:password']
        ]);

        $user = $request->user();
        if (Hash::check($request->password, $user->password)) {
            throw ValidationException::withMessages([
                'password_previous' =>  'No previously used password'
            ]);
        }


        $user->update([
            'password'  =>  bcrypt($request->password),
        ]);

        return response([
            // 'data'  =>  new MobileAppUserResource($user->fresh()),
            'status'    =>  true,
        ], Response::HTTP_OK);
    }

    /**
     * Update profile information
     *
     * @param Request $request
     * @return void
     */
    public function update(UpdateProfileRequest $request)
    {

        $user = $request->user();
        if(!$request->current_password) {
            return $user;
        }
        $data = $request->validated();
        if ($request->email !== $user->email && !$request->otp) {
            $this->sendEmailChangeOtpMail($request);
            return response((new MobileAppUserResource($user->fresh()))->additional(['status' => true]), Response::HTTP_ACCEPTED);
        }

        if (isset($data['photo'])) {
            $image = \Image::make($data['photo'])->encode('jpg');
            $path = "user/" . Str::uuid() . ".jpg";

            Storage::disk(getDisk())->put($path, $image);
            $user->photo ? Storage::disk(getDisk())->delete($user->photo) : null;
            $data['photo'] = $path;
        }
        $data['country'] = $data['country_iso_code'] ?? null;
        $user->update($data);
        return response((new MobileAppUserResource($user->fresh()))->additional(['status' => true]), Response::HTTP_ACCEPTED);
    }

    public function sendEmailChangeOtpMail(Request $request)
    {
        $request->validate([
            'email' => 'email:filter|required'
        ]);
        $otp = mt_rand(10000, 99999);
        $otp = EmailVerification::updateOrCreate(
            ['email' => $request->email],
            ['token' => $otp, 'mobile_app_user_id' => $request->user('appusers')->id]
        )->token;
        Mail::to($request->email)->send(new AppUserEmailChangeOtpMail($otp));
        return true;
    }

    public function passwordCheck(Request $request)
    {
        $request->validate([
            'current_password' => "required|current_password:appusers"
        ]);
        return false;
    }
}
