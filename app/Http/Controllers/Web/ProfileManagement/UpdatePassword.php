<?php

namespace App\Http\Controllers\Web\ProfileManagement;

use App\Http\Controllers\Controller;
use App\Rules\NotCurrentPassword;
use Illuminate\Http\Request;
use Illuminate\Validation\Rules\Password;
use Inertia\Inertia;

use function PHPSTORM_META\map;

class UpdatePassword extends Controller
{
    public function show()
    {
        return Inertia::render('ProfileManagement/UpdatePassword');
    }

    public function update(Request $request)
    {
        $request->validate([
            'current_password' => ['required', 'current_password'],
            'password' => ['required', Password::min(8)->letters()->mixedCase()->numbers()->symbols(), new NotCurrentPassword()],
            'password_confirmation' => ['required', 'same:password']
        ], [
            'current_password' => 'Please enter the the old password correctly',
            'password.required' => 'The password field is required.',
            'password' => 'Min 8 characters with at least 1 letter, number and symbol',
            'password_confirmation.required' => 'The confirm password field is required',
            'confirm_password' => 'Password doesn’t match'
        ]);
        $user = $request->user();
        $user->update([
            'password'  =>  bcrypt($request->password),
        ]);

        return redirect(route('products.index'))->with('message', 'Your password has been changed successfully');
    }
}
