<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    public function index(){
        $user = Auth::user();

        return view('profile.index', compact('user'));
    }

    public function verifikasi(){
        return ;
    }

    public function otp(){
        return view('profile.otp', compact('user'));
    }

    public function edit(){
        return view('profile.edit');
    }

    public function update(){
        return;
    }
}
