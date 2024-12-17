<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AccountingController extends Controller
{
    public function index(){
        return view('accounting.account.index');
    }

    public function store(){
        return view('accounting.account.index');
    }
}
