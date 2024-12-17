<?php

namespace App\Http\Controllers;

use App\Mail\OtpMail;
use App\Models\ActiveLogin;
use App\Models\Otp;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class AuthController extends Controller
{
    public function login(){
        $user = Auth::user();
        if($user)
            return redirect()->route('dashboard');

        return view('auth.login');
    }

    public function submitLogin(Request $request)
    {
        $credentials = $request->only('email', 'password');
    
        if (Auth::attempt($credentials, $request->get('remember_me'))) {
            $user = Auth::user();
    
            $uniqLoginId = (string) Str::uuid();
            ActiveLogin::create([
                'uniq_login_id' => $uniqLoginId,
                'user_id' => $user->id,
            ]);
    
            Session::put('uniq_login_id', $uniqLoginId);
    
            if ($request->get('remember_me')) {
                Cookie::queue(Cookie::make('uniq_login_id', $uniqLoginId, 10080));
                config(['session.lifetime' => 10080]);
            } else {
                Cookie::queue(Cookie::make('uniq_login_id', $uniqLoginId, 120)); // Default session time
            }
    
            $prev_url = Session::get('prev_url');
            if ($prev_url) {
                return redirect()->away($prev_url);
            }
    
            return redirect()->intended('/dashboard');
        }
    
        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ]);
    }

    public function logout(Request $request)
    {
        $uniqLoginId = Cookie::get('uniq_login_id');

        if ($uniqLoginId) {
            ActiveLogin::where('uniq_login_id', $uniqLoginId)->delete();
        }

        Cookie::queue(Cookie::forget('uniq_login_id'));
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login');
    }

    public function withEmail(Request $request){
        $validator = Validator::make($request->all(), [
            'email' => 'required|email|exists:users,email',
        ]);

        if($validator->fails()){
            $errorMessages = $validator->errors()->all();
            $errorMessageText = implode(' ', $errorMessages);
            return redirect()->back()
                ->withErrors($validator)
                ->withInput()
                ->with('warning', $errorMessageText);
        }else{
            $user = User::where('email', $request->get('email'))->first();

            // Delete any existing OTP for the user
            Otp::where('user_id', $user->id)->delete();

            // Generate a unique 6-digit OTP
            do {
                $otp = mt_rand(100000, 999999);
            } while (Otp::where('otp', $otp)->exists());

            // Store the OTP in the database
            Otp::create([
                'user_id' => $user->id,
                'otp' => $otp,
            ]);

            $data['otp'] = $otp;
            Mail::to($request->get('email'))->send(new OtpMail($data));

            return redirect()->route('login.otp', ['email' => $request->get('email')])->with('success', 'Berhasil mengirimkan otp ke '.$request->get('email'));
        }  
    }   

    public function withPhone(Request $request){
        $validator = Validator::make($request->all(), [
            'phone' => 'required|numeric|exists:users,phone',
        ]);

        if($validator->fails()){
            $errorMessages = $validator->errors()->all();
            $errorMessageText = implode(' ', $errorMessages);
            return redirect()->back()
                ->withErrors($validator)
                ->withInput()
                ->with('warning', $errorMessageText);
        }else{
            $user = User::where('phone', $request->get('phone'))->first();

            // Delete any existing OTP for the user
            Otp::where('user_id', $user->id)->delete();

            // Generate a unique 6-digit OTP
            do {
                $otp = mt_rand(100000, 999999);
            } while (Otp::where('otp', $otp)->exists());

            // Store the OTP in the database
            Otp::create([
                'user_id' => $user->id,
                'otp' => $otp,
            ]);

            $data['otp'] = $otp;
            $message = "Kami menerima permintaan masuk ke sistem informasi ".env('APP_NAME').", Silahkan masukkan kode OTP : *$otp* untuk melanjutkan login. Segera beritahu admin apabila permintaan ini bukan dari anda!";
            $this->sendMessage($request->get('phone'), $message);

            return redirect()->route('login.otp', ['phone' => $request->get('phone')])->with('success', 'Berhasil mengirimkan otp ke '.$request->get('phone'));
        }
    }

    public function otp(){
        $email = request()->query('email');
        $phone = request()->query('phone');

        return view('auth.otp', compact('email', 'phone'));
    }

    public function submitOtp(Request $request){
        $user = null;
        if($request->has('email')){
            $validator = Validator::make($request->all(), [
                'otp' => [
                    'required',
                    'numeric',
                    'digits:6',
                    'exists:otp,otp',
                    function ($attribute, $value, $fail) use ($request) {
                        $user = User::where('email', $request->email)->first();
                        if (!$user) {
                            $fail('User not found.');
                            return;
                        }
                        $otp = Otp::where('otp', $value)
                            ->where('user_id', $user->id)
                            ->where('created_at', '>=', now()->subMinutes(5))
                            ->first();

                        if (!$otp) {
                            $fail('The OTP is invalid or has expired.');
                        }
                    },
                ],
                'email' => 'required|email|exists:users,email',
            ]);

            if($validator->fails()){
                $errorMessages = $validator->errors()->all();
                $errorMessageText = implode(' ', $errorMessages);
                return redirect()->back()
                    ->withErrors($validator)
                    ->withInput()
                    ->with('warning', $errorMessageText);
            }

            $user = User::where('email', $request->email)->first();

        }else if($request->has('phone')){
            $validator = Validator::make($request->all(), [
                'otp' => [
                    'required',
                    'numeric',
                    'digits:6',
                    'exists:otp,otp',
                    function ($attribute, $value, $fail) use ($request) {
                        $user = User::where('phone', $request->phone)->first();
                        if (!$user) {
                            $fail('User not found.');
                            return;
                        }
                        $otp = Otp::where('otp', $value)
                            ->where('user_id', $user->id)
                            ->where('created_at', '>=', now()->subMinutes(5))
                            ->first();

                        if (!$otp) {
                            $fail('The OTP is invalid or has expired.');
                        }
                    },
                ],
                'phone' => 'required|numeric|exists:users,phone',
            ]);

            if($validator->fails()){
                $errorMessages = $validator->errors()->all();
                $errorMessageText = implode(' ', $errorMessages);
                return redirect()->back()
                    ->withErrors($validator)
                    ->withInput()
                    ->with('warning', $errorMessageText);
            }

            $user = User::where('phone', $request->phone)->first();
        }

        if ($user) {
            Auth::login($user);

            $uniqLoginId = (string) Str::uuid();
            ActiveLogin::create([
                'uniq_login_id' => $uniqLoginId,
                'user_id' => $user->id,
            ]);

            Session::put('uniq_login_id', $uniqLoginId);

            if ($request->get('remember_me')) {
                Cookie::queue(Cookie::make('uniq_login_id', $uniqLoginId, 10080));
                config(['session.lifetime' => 10080]);
            } else {
                Cookie::queue(Cookie::make('uniq_login_id', $uniqLoginId, 120));
            }

            // Delete the used OTP
            Otp::where('user_id', $user->id)->delete();

            $prev_url = Session::get('prev_url');
            if ($prev_url) {
                return redirect()->away($prev_url);
            }

            return redirect()->intended('/dashboard');
        }

        return redirect()->back()->with('error', 'An error occurred during authentication.');
    }

    public function sendMessage($phone, $message)
    {
        // Prepare data as JSON
        $data = [
            'phone' => $phone,
            'message' => $message,
        ];

        // Send POST request
        $response = Http::withHeaders([
            'Content-Type' => 'application/json',
        ])->post(env('WHATSAPP_SERVER').'/api/send-message', $data);

        // Log or display the response
        if ($response->successful()) {
            return response()->json([
                'status' => true,
                'message' => 'Pesan berhasil dikirim',
                'data' => $response->json(),
            ], 200);
        } else {
            return response()->json([
                'status' => false,
                'message' => 'Gagal mengirim pesan',
                'data' => $response->json(),
            ], $response->status());
        }
    }
}
