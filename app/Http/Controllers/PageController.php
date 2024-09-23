<?php

namespace App\Http\Controllers;

use App\Models\Application;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;

class PageController extends Controller
{
    public function dashboard(){
        $applications = Application::all();
        $count = [
            'apps' => count($applications),
            'users' => count(User::all()),
            'roles' => count(Role::all())
        ];
        return view('dashboard.index', compact('applications', 'count'));
    }
}
