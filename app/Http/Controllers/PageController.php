<?php

namespace App\Http\Controllers;

use App\Models\Application;
use Illuminate\Http\Request;
use App\Models\Role;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class PageController extends Controller
{
    public function dashboard(){
        $user = Auth::user();

        // Mengambil peran pertama dan memuat relasi aplikasi
        $role = $user->nameroles()->with('applications')->first();
        $apps = $role ? $role->applications : collect();

        return view('dashboard.index', compact('user', 'apps'));
    }
}
