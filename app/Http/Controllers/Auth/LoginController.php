<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;

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

    // Redirect User After Login Directly
    protected function authenticated(Request $request, $user)
    {
        if ($user->hasRole( __('content.owner') )) 
            return redirect(RouteServiceProvider::ADMIN);
        else
            return redirect(RouteServiceProvider::FRONTEPAGE);
    }

    // user can't access to system if status 0
    protected function attemptLogin(Request $request)
    {
        $credentials = array_merge( $this->credentials($request), ['status'=>1] );
        return $this->guard()->attempt(
            $credentials, $request->filled('remember')
        );
    }

    protected function credentials(Request $request)
    {
        return $request->only($this->username(), 'password', 'status');
    }


}
