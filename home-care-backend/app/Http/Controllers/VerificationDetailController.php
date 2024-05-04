<?php

namespace App\Http\Controllers;

use App\Models\Country;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class VerificationDetailController extends Controller
{
    public function sendOtp(Request $request)
    {
        $request->validate([
            'country_id' => 'required',
            'phone' => 'required'
        ]);

        $phone_check = User::where('phone', $request->phone)->first();

        if ($phone_check && $phone_check->id != Auth::user()->id) {
            return response()->json([
                'success' => false,
                'message' => 'Phone number already in use'
            ]);
        }

        $country = Country::find($request->country_id);
        $phone = $country->phonecode . $request->phone;

        $send_otp = Http::post(env('TERMII_URL') . '/sms/otp/send', [
            'api_key' => env('TERMII_KEY'),
            "message_type" => "NUMERIC",
            "to" => $phone,
            "from" => "N-Alert",
            "channel" => "dnd",
            "pin_attempts" => 4,
            "pin_time_to_live" =>  10,
            "pin_length" => 6,
            "pin_placeholder" => "< 1234 >",
            "message_text" => "Your Malo verification pin is < 1234 > This pin will be invalid after 20 minutes",
            "pin_type" => "NUMERIC"
        ]);

        $res = $send_otp->json();
        if (!Arr::exists($res, 'pinId')) {
            return response()->json([
                'success' => false,
                'message' => 'Error while sending OTP, please try again'
            ]);
        }
        VerificationDetail::updateOrCreate(
            ['user_id' => Auth::user()->id],
            ['phone_pin' => $res['pinId']]
        );

        return response()->json([
            'success' => true,
            'message' => 'Phone verification pin sent'
        ]);
    }

    public function verifyPhone(Request $request)
    {
        $request->validate([
            'phone' => 'required',
            'country_id' => 'required',
            'otp' => 'required'
        ]);

        $phone_check = User::where('phone', $request->phone)->first();
        if ($phone_check && $phone_check->id != Auth::user()->id) {
            return response()->json([
                'success' => false,
                'message' => 'Phone number already in use'
            ]);
        }

        $verify_otp = Http::post(env('TERMII_URL') . '/sms/otp/verify', [
            'api_key' => env('TERMII_KEY'),
            "pin_id" => Auth::user()->verification->phone_pin,
            "pin" => $request->otp
        ]);


        $res = $verify_otp->json();


        if (!Arr::exists($res, 'verified') || $res['verified'] != true) {
            return response()->json([
                'success' => false,
                'message' => 'Phone verification failed, please try again'
            ]);
        }

        Auth::user()->phone_verified_at = now();
        Auth::user()->phone = $request->phone;
        Auth::user()->save();

        return response()->json([
            'success' => true
        ]);
    }

    public function verifyPhonePage(User $user)
    {
        return response()->json([
            'user' => $user,
            'success' => true
        ]);
    }
}
