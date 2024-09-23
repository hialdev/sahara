<?php

namespace App\Http\Controllers;

use App\Models\ActiveLogin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;

class AuthController extends Controller
{
    public function login(){
        return view('auth.login');
    }
    public function submitLogin(Request $request)
    {
        // Proses autentikasi
        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials, $request->get('remember_me'))) {
            $user = Auth::user();

            // Generate uniq_login_id
            $uniqLoginId = (string) Str::uuid();

            // Simpan ke tabel active_login
            ActiveLogin::create([
                'uniq_login_id' => $uniqLoginId,
                'user_id' => $user->id,
            ]);

            Session::put('uniq_login_id', $uniqLoginId);
            Cookie::queue(Cookie::make('uniq_login_id', $uniqLoginId, 1080, '/', '.sahara.test'));

            $prev_url = Session::get('prev_url');
            // dd(Cookie::get(), $uniqLoginId);
            if($prev_url)
                return redirect()->away($prev_url);

            return redirect()->intended('/dashboard');
        }

        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ]);
    }

    public function logout(Request $request)
    {
        // Hapus uniq_login_id dari cookie
        $uniqLoginId = Cookie::get('uniq_login_id');

        // Jika uniq_login_id ditemukan di cookie, hapus dari active_login
        if ($uniqLoginId) {
            ActiveLogin::where('uniq_login_id', $uniqLoginId)->delete();
        }

        // Hapus uniq_login_id dari cookie
        Cookie::queue(Cookie::forget('uniq_login_id'));
        // Logout dari sesi Laravel
        Auth::logout();

        // Hapus semua sesi
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        // Redirect ke halaman login atau halaman lainnya
        return redirect()->route('login');
    }
}
