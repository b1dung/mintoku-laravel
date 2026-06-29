<?php

namespace Mintoku\UserAuth\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function showLoginForm()
    {
        return view("user-auth::login");
    }

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }

    public function login(Request $request)
    {
        $request->validate([
            "email" => ["required", "email"],
            "password" => ["required"],
        ], [
            "email.required" => "Vui lòng nhập địa chỉ email.",
            "email.email"    => "Địa chỉ email không đúng định dạng.",
            "password.required" => "Vui lòng nhập mật khẩu.",
        ]);

        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            return redirect()->route('user.job.index');
        }

        return back()->withErrors([
            "email" => "Email hoặc mật khẩu không chính xác."
        ])->onlyInput('email');
    }
}
