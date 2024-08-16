<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Cache;
use Illuminate\Http\Request;

class LoginController extends Controller {
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
    protected $redirectTo = '/user/profile';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct() {
        if(isset($_POST['affiliate_key'])){
            $this->redirectTo = route('affiliate-shop', $_POST['affiliate_key']);
        }
        $this->middleware('guest')->except('logout');
    }
    protected function authenticated(Request $request, $user)
    {
        // Redirect based on user role
        if ($user->role === 'admin') {
            return redirect('/user/profile');
        }

        // For regular users, redirect to the previous URL or fallback to default redirect
        return redirect()->intended(url()->previous());
    }
    public function showLoginForm(Request $request)
    {
        // Store the intended URL
        
        $request->session()->put('url.intended', url()->previous());
        
        return view('auth.login');
    }

}
