<?php

namespace App\Http\Controllers;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Mail\Message;
use Illuminate\Support\Facades\Mail;
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
        $user = User::where("email", $request->email)->first();
        if (!$user) {
            return back()->withErrors(["email" => "email bulunamadı"]);
        }
        $token = Password::createToken($user);
        $resetUrl = route("password.reset", ["token" => $token, "email" => $user->email]);

        $expires = Carbon::now()->addMinutes(60);

        Mail::send("mail.reset", ["resetUrl" => $resetUrl, "expires" => $expires], function (Message $message) use ($request) {
            $message->to($request->email)->subject("Sıfırlama Maili");
        });
        return back()->withSuccess("Sıfırlama Maili Gönderildi");

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
