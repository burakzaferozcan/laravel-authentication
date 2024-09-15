<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CustomAuthController extends Controller
{
    //
    public function create(){
        return view("auth.register");
    }

    public function login(){
        return view("auth.login");
    }

    public function index(){
        return view("auth.profile");
    }

    public function logout(){
        return redirect("/");
    }
}
