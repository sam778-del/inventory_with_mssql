<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Models\User;
use Auth;

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
        // if(!file_exists(storage_path() . "/installed"))
        // {
        //     header('location:install');
        //     die;
        // }
        $this->middleware('guest')->except('logout');
    }

    public function __invoke()
    {
        return view('auth.login');
    }

    public function authLogin(LoginRequest $request)
    {
        $request->authenticate();

        $password = $request->has('password') ? $request->password : '';
        $user = User::where('password', $password)->first();
        return $user;
        // if ($user = User::where('password', $password)->first()) {
        //     Auth::login($user);
        //     return redirect()->intended('/');
        // }else{
        //     return redirect()->back()->with('error', __('Credentials Doesn\'t Match !'));
        // }
    }

    public function authLogout(Request $request)
    {
        Auth::guard('web')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/');
    }
}