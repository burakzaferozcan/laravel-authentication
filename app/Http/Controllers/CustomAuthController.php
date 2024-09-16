<?php

namespace App\Http\Controllers;

use App\Mail\VerifyEmail;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Spatie\Permission\Models\Role;

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
        $user = User::create(['name' => $request->name,
            'email' => $request->email,
            'password' => $request->password,
            'email_token' => Str::random(60)]);

        $demoRole = Role::findByName("Member");
        $user->assignRole($demoRole->id);
        Mail::to($user->email)->send(new VerifyEmail($user));
        Auth::login($user);
        return redirect()->to("/profile");
    }

    public function login(Request $request)
    {
        if ($request->method() == "POST") {
            $credentials = $request->validate([
                'email' => ['required', 'email'],
                'password' => ['required']
            ]);
            if (Auth::attempt($credentials)) {
                return redirect()->to("/profile")->withSuccess("Welcome");
            }
            return back()->withError("Username or password incorrect");

        }
        return view("auth.login");

    }
    public function verifyEmail($token)
    {
        $user=User::where("email_token",$token)->firstOrFail();
        if ($user){
            $user->email_token = NULL;
            $user->email_verified_at = now();
            $user->save();

            return redirect()->to("login")->with("success","Başarıyla Doğruladınız");
        }

        return redirect()->to("login")->with("error","Token Hatalı");

    }

    public function index(Request $request)
    {
        if (Auth::check()) {
            $user = Auth::user();
            if (!$user->can("read-users")) {
                abort(403, "Bu işlemi gerçekleştirmek için yetkiniz yok.");
            }
            if($user->email_verified_at==null){
                return "Hesap henüz doğrulanmadı.";
            }
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
