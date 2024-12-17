<?php

namespace App\Http\Middleware;

use App\Models\ActiveLogin;
use App\Models\Role;
use Carbon\Carbon;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\URL;

class CheckSSOLogin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
       // Mengambil nilai uniq_login_id dari sesi
        $uniqLoginId = Session::get('uniq_login_id');

        // Debugging: lihat nilai uniq_login_id
        Log::info('uniq_login_id dari sesi: ' . $uniqLoginId);

        if ($uniqLoginId) {
            $activeLogin = ActiveLogin::where('uniq_login_id', $uniqLoginId)
                ->where('created_at', '>=', Carbon::now()->subDays(7))
                ->first();

            // Debugging: lihat apakah activeLogin ditemukan
            Log::info('ActiveLogin ditemukan: ' . ($activeLogin ? 'Ya' : 'Tidak'));
            $roleName = Auth::user()->getRoleNames()[0];
            $role = Role::where('name', $roleName)->first();
            $checkApp = $role->applications->contains('id', env('APP_ID'));

            if ($activeLogin && $checkApp) {
                // Jika valid, lanjutkan request
                return $next($request);
            }else{
                return redirect()->away(env('ACCOUNT_URL'));
            }
        }
        
        Session::put('prev_url', URL::full());
        // Jika tidak valid, redirect ke halaman login
        // Jika tidak valid, redirect ke halaman login
        return redirect()->away(env('ACCOUNT_URL').'/login');
    }
}
