<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Mail\VerificationMail;
use App\Models\Country;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Mail;
use Illuminate\Validation\Rules;

class RegisteredUserController extends Controller
{
    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request)
    {
        $request->validate([
            'full_name' => ['required', 'string', 'max:255'],
            'user_type' => ['required'],
            'verification_type' => 'required',
            'email' => ['required', 'string', 'email', 'max:255', 'unique:' . User::class],
            'password' => ['required', 'confirmed', 'min:8'], // add this later  new StrongPassword
            'phone' => 'required',
            'country_code' => 'required',
        ]);

        $checkPhone = User::where('phone', $request->phone)->exists();
        if ($checkPhone) {
            return response()->json(
                [
                    'success' => false,
                    'message' => 'phone number already exists',
                ],
                403
            );
        }

        $user = User::create([
            'full_name' => $request->full_name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'country_id' => $request->country_code,
            'user_type' => $request->user_type,
            'verificationType' => $request->verification_type,
            'phone' => $request->phone,
        ]);

        if ($user->verificationType == 'phone') {
            //send otp

            $phone =$request->phone;

            $send_otp = Http::post(env('TERMII_URL') . '/sms/otp/send', [
                'api_key' => env('TERMII_KEY'),
                "message_type" => "NUMERIC",
                "to" => $phone,
                "from" => "pesinal",
                "channel" => "WhatsApp",
                "pin_attempts" => 4,
                "pin_time_to_live" =>  10,
                "pin_length" => 6,
                "pin_placeholder" => "< 1234 >",
                "message_text" => "Your home_care verification pin is < 1234 > This pin will be invalid after 10 minutes",
                "pin_type" => "NUMERIC"
            ]);
            $res = $send_otp->json();

            \Log::info($res);
            if (!Arr::exists($res, 'pinId')) {
                return response()->json([
                    'response' => $res,
                    'user' => $user,
                    'success' => false,
                    'message' => 'Error while sending OTP, please try logging in',
                ]);
            }
            VerificationDetail::updateOrCreate(
                ['user_id' => $user->id],
                ['phone_pin' => $res['pinId']]
            );


        } else {
            $code = rand(10000, 99990);
            $boldCode = '<strong>'.$code.'</strong>';
            Mail::to($user)->send(new VerificationMail($boldCode));
            $user->email_code = $code;
            $user->save();
        }


        event(new Registered($user));

        Auth::login($user);

        //return response()->noContent();
        return response()->json(
            [
                'success' => true,
                'message' => 'Registered',
                'user' => $user,
            ],
            201
        );
    }
}
