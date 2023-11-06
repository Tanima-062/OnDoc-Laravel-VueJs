<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use Inertia\Inertia;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Validation\ValidationException;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }




    /**
     * Show the application's login form.
     *
     * @return \Illuminate\View\View
     */
    public function showLoginForm()
    {
        $message = session('message') ?? null;
        session()->forget('message');

        return Inertia::render('Auth/Login', [
            'message'   =>  $message
        ]);
    }


    /**
     * Get the needed authorization credentials from the request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    protected function credentials(Request $request)
    {
        $credential = [
            'password'  =>  $request->password,
            'status' => User::STATUS_ACTIVE,
            'type'  =>  ['company_admin', 'company_sub_admin']
        ];

        return $credential + ['email'  =>  $request->email,];
    }

    /**
     * Validate the user login request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return void
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    protected function validateLogin(Request $request)
    {
        $request->validate([
            'email' => 'required|string',
            'password' => 'required|string',
        ]);
    }




    /**
     * Get the login username to be used by the controller.
     *
     * @return string
     */
    public function username()
    {
       return 'email';
    }


     /**
     * Get the failed login response instance.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Symfony\Component\HttpFoundation\Response
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    protected function sendFailedLoginResponse(Request $request)
    {
        throw ValidationException::withMessages([
            'invalid_credentials' => [trans('auth.failed')],
        ]);
    }


     /**
     * Show the application's login form.
     *
     * @return \Illuminate\View\View
     */
    public function showSystemLoginForm()
    {
        $message = session('message') ?? null;
        session()->forget('message');

        return Inertia::render('Auth/SystemLogin', [
            'message'   =>  $message
        ]);
    }


    /**
     * Handle a login request to the application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\Response|\Illuminate\Http\JsonResponse
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function systemLogin(Request $request)
    {
        $this->validateLogin($request);

        // If the class is using the ThrottlesLogins trait, we can automatically throttle
        // the login attempts for this application. We'll key this by the username and
        // the IP address of the client making these requests into this application.
        if (method_exists($this, 'hasTooManyLoginAttempts') &&
            $this->hasTooManyLoginAttempts($request)) {
            $this->fireLockoutEvent($request);

            return $this->sendLockoutResponse($request);
        }

        if ($this->systemAttemptLogin($request)) {
            if ($request->hasSession()) {
                $request->session()->put('auth.password_confirmed_at', time());
            }

            return $this->sendLoginResponse($request);
        }

        // If the login attempt was unsuccessful we will increment the number of attempts
        // to login and redirect the user back to the login form. Of course, when this
        // user surpasses their maximum number of attempts they will get locked out.
        $this->incrementLoginAttempts($request);

        return $this->sendFailedLoginResponse($request);
    }

        /**
     * Attempt to log the user into the application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return bool
     */
    protected function systemAttemptLogin(Request $request)
    {
        return $this->guard()->attempt(
            $this->systemCredentials($request), $request->boolean('remember')
        );
    }


      /**
     * Get the needed authorization credentials from the request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    protected function systemCredentials(Request $request)
    {
        $credential = [
            'password'  =>  $request->password,
            'status' => User::STATUS_ACTIVE,
            'type'  =>  ['system_admin',]
        ];

        return $credential + ['email'  =>  $request->email,];
    }



    /**
     * Log the user out of the application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\JsonResponse
     */
    public function logout(Request $request)
    {
        if($request->user()->type == User::SYSTEM_ADMIN){
            $this->guard()->logout();

            $request->session()->invalidate();
            $request->session()->regenerateToken();

            return redirect(route('system.login'));
        }else {

            $this->guard()->logout();

            $request->session()->invalidate();

            $request->session()->regenerateToken();

            if ($response = $this->loggedOut($request)) {
                return $response;
            }

            return $request->wantsJson()
                ? new JsonResponse([], 204)
                : redirect('/');

        }
    }
}
