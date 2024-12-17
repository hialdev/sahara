<?php

namespace App\Http\Controllers;

use App\Mail\OtpMail;
use App\Models\ActiveLogin;
use App\Models\Otp;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class ProfileController extends Controller
{
    public function index(){
        $user = Auth::user();

        return view('profile.index', compact('user'));
    }

    public function verifikasi(){
        $phone = request()->query('phone');
        $email = request()->query('email');
        
        return view('profile.verifikasi', compact('email','phone'));
    }

    public function change(Request $request){
        $validator = Validator::make($request->all(), [
            'password' => 'required|string',
            'confirm_password' => 'required|string|same:password',
            'new_password' => 'nullable|string|min:8',
            'confirm_new_password' => 'nullable|string|same:new_password',
            'email' => 'nullable|email|unique:users,email',
            'phone' => 'nullable|numeric|unique:users,phone',
        ]);

        if($validator->fails()){
            $errorMessages = $validator->errors()->all();
            $errorMessageText = implode(' ', $errorMessages);
            return redirect()->back()
                ->withErrors($validator)
                ->withInput()
                ->with('error', $errorMessageText);
        }

        $user = Auth::user()->id;
        $user = User::find($user);

        // Verify the current password
        if (!Hash::check($request->get('password'), $user->password)) {
            return redirect()->back()
                ->withInput()
                ->with('warning', 'Password yang dimasukkan tidak sesuai dengan password saat ini.');
        }

        // Update email if provided and different
        if($request->get('email') && $user->email != $request->get('email')){
            $user->email = $request->get('email');
            $user->email_verified_at = null;
        }

        // Update phone if provided and different
        if($request->get('phone') && $user->phone != $request->get('phone')){
            $user->phone = $request->get('phone');
            $user->phone_verified_at = null;
        }

        // Update password if new password is provided
        if($request->get('new_password')){
            $user->password = Hash::make($request->get('new_password'));
        }

        $user->save();

        return redirect()->route('profile.index')->with('success', 'Berhasil mengubah data, harap verifikasi ulang jika diperlukan.');
    }

    public function verifikasiEmail(Request $request){
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
            Mail::to($request->get('email'))->send(new OtpMail ($data));

            return redirect()->route('verifikasi.index', ['email' => $request->get('email')])->with('success', 'Berhasil mengirimkan otp ke '.$request->get('email'));
        }  
    }   

    public function verifikasiPhone(Request $request){
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

            return redirect()->route('verifikasi.index', ['phone' => $request->get('phone')])->with('success', 'Berhasil mengirimkan otp ke '.$request->get('phone'));
        }
    }

    public function edit(){
        return view('profile.edit');
    }

    public function submitVerifikasi(Request $request){
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
            $user->email_verified_at = Carbon::now();
            $user->save();

            return redirect()->route('profile.index')->with('success', 'Berhasil memverifikasi email');
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
            $user->phone_verified_at = Carbon::now();
            $user->save();

            $otps = Otp::where('user_id', $user->id)->get();
            foreach ($otps as $otp) {
                $otp->delete();
            }

            return redirect()->route('profile.index')->with('success', 'Berhasil memverifikasi phone');
        }

        return redirect()->back()->with('error', 'An error occurred during verification.');
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
