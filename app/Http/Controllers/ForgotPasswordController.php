<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;

class ForgotPasswordController extends Controller
{
    public function showLinkRequestForm()
    {
        return view('auth.email');
    }

    public function sendResetLinkEmail(Request $request)
    {
        $request->validate(['email' => 'required|email']);
        $status = Password::sendResetLink(
            $request->only('email')
        );
        return $status === Password::RESET_LINK_SENT ? back()->withSuccess($status) : back()->withErrors(["email" => $status]);
    }

    public function showResetForm(Request $request, $token)
    {
        return view('auth.reset', ["token" => $token, "email" => $request->email]);
    }

    public function reset(Request $request)
    {
        $request->validate([
            'token' => 'required',
            'email' => 'required|email',
            'password' => 'required|min:8|confirmed',
        ]);
        $status = Password::reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),

            function ($user, $password) {
                $user->forceFill([
                    "password" => bcrypt($password),
                ])->save();
            }
        );
        return $status == Password::PASSWORD_RESET ? redirect()->to("/login")->withSuccess($status) : back()->withErrors(["email" => $status]);
    }
}
