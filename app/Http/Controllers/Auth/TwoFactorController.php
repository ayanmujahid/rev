<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class TwoFactorController extends Controller {
    public function showForm()
    {
        return view('auth.2fa');
    }

    public function verifyOtp(Request $request)
    {
        $request->validate([
            'otp' => 'required|size:6'
        ]);

        $sessionOtp = Session::get('2fa')['otp'];
        if ($request->input('otp') === $sessionOtp) {
            Session::put('2fa.validated', true);
            return redirect()->route('dashboard');
        }

        return redirect()->route('2fa.verify')->withErrors(['otp' => 'Invalid OTP']);
    }
}
