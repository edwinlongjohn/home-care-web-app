<?php

namespace App\Http\Controllers;

use App\Mail\VerificationMail;
use App\Models\Country;
use App\Models\User;
use App\Rules\StrongPassword;
use Illuminate\Http\Request;
use App\Models\VerificationDetail;
use League\CommonMark\Extension\CommonMark\Renderer\Inline\StrongRenderer;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use PDO;

class ApiAuthController extends Controller
{
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required',
            'password' => 'required'
        ]);

        $user = Auth::attempt(['email' => $request->email, 'password' => $request->password]);

        if (!$user) {
            return response()->json([
                'success' => false,
                'message' => 'Incorrect credentials'
            ]);
        }

        $token = $request->user()->createToken('mobile');

        return response()->json([
            'success' => true,
            'token' => $token->plainTextToken,
            'user' => Auth::user(),
        ]);
    }

    public function register(Request $request)
    {
        $request->validate([
            'full_name' => ['required', 'string', 'max:255'],
            'user_type' => ['required'],
            'verification_type' => 'required',
            'email' => ['required', 'string', 'email', 'max:255', 'unique:' . User::class],
            'password' => ['required', 'confirmed', new StrongPassword],
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
            'country_id' => $request->country_id,
            'user_type' => $request->user_type,
            'verficationType' => $request->verification_type,
            'phone' => $request->phone,
        ]);

        if ($user->verificationType = 'phone') {
            //send otp
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
                $token = $user->createToken('register')->plainTextToken;
                return response()->json([
                    'user' => $user,
                    'token' => $token,
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

        $token = $user->createToken('register')->plainTextToken;

        $response = [
            'user' => $user,
            'token' => $token,
        ];


        return response()->json(
            [
                'message' => 'Registered',
                'response' => $response,
            ],
            201
        );
    }

    public function countries()
    {
        $countries = Country::orderBy('phonecode', 'asc')->get();

        return response()->json(['success' => true, 'countries' => $countries]);
    }

    public static function sendEmailCode(User $user = null)
    {
        if ($user == null) {
            $user = Auth::user();
        }
        $code = rand(10000, 99990);
        $boldCode = '<strong>'.$code.'</strong>';
        Mail::to($user)->queue(new VerificationMail($boldCode));
        $user->email_code = $code;
        $user->save();
        return response()->json(['success' => true]);
    }

    public function verifyEmail(Request $request)
    {
        $request->validate([
            'pin' => 'required'
        ]);

        if (Auth::user()->email_code != $request->pin) {
            return response()->json(['success' => false, 'message' => 'Invalid email verification code']);
        }

        Auth::user()->email_verified_at = now();
        Auth::user()->save();

        return response()->json(['success' => true]);
    }
}
