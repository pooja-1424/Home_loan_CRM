<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AuthController extends Controller
{
    //
    public function login()
    {
        return view('widgets');
    }
    public function register(){
        return view('auth.register');
    }
}
