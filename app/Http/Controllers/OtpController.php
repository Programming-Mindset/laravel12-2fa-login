<?php

namespace App\Http\Controllers;

use App\Models\Otp;
use App\Services\OtpService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OtpController extends Controller
{
    private OtpService $otpService;

    public function __construct()
    {
        $this->otpService = new OtpService();

    }

    public function verifyOtpForm(Request $request)
    {
        $user = Auth::user();
        if (!$user) {
            abort(401, 'User not authenticated');
        }

        // Fetch latest OTP for the user
        $otpRecord = Otp::where('user_id', $user->id)->latest()->first();


        if (!$otpRecord) {
            return redirect('/dashboard');
        }

        return view('verify-otp');
    }


    public function verifyOtp(Request $request)
    {
        $request->validate([
            'otp' => 'required|numeric',
        ]);


        $user = Auth::user();


        if (!$user) {
            abort(401, 'User not authenticated');
        }

        // Fetch latest OTP for the user
        $otpRecord = Otp::where('user_id', $user->id)->latest()->first();


        if (!$otpRecord || $otpRecord->isExpired() || $otpRecord->otp != $request->otp) {
            flash()->addError('Invalid or expired token');
            return redirect('/verify-otp');
        }

        // OTP is valid, delete it
        $otpRecord->delete();

        flash()->addSuccess('OTP verified successfully.');
        return redirect('/dashboard');
    }
}
