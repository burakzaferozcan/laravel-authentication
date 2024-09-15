<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CustomAuthController extends Controller
{
    //
    public function create()
    {
        return view("auth.register");
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required|confirmed'
        ]);
        $user = User::create($request->only(['name', 'email', 'password']));
        Auth::login($user);
        return redirect()->to("/profile");
    }

    public function login(Request $request)
    {
        if ($request->method() == "POST") {
            $credentials=$request->validate([
                'email'=>['required','email'],
                'password'=>['required']
            ]);
            if (Auth::attempt($credentials)) {
                return redirect()->to("/profile")->withSuccess("Welcome");
            }
            return back()->withError("Username or password incorrect");

        }
        return view("auth.login");

    }

    public function index(Request $request)
    {
        if (Auth::check()) {
            return Auth::user();
        }
        return redirect("/login");
    }

    public function logout()
    {
        Auth::logout();
        return redirect()->to("/")->withSuccess("Exit made.");
    }
}
