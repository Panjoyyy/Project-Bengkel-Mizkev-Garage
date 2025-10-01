<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function login()
    {
        $title = 'Silakan login';
        return view('login', compact('title'));
    }

    public function handleLogin(Request $request)
    {
        $credentials = $request->validate([
            'username' => 'required',
            'password' => 'required'
        ], [
            'username.required' => 'Kolom nama pengguna tidak boleh kosong',
            'password.required' => 'Kolom kata sandi tidak boleh kosong',
        ]);

        if (Auth::attempt($credentials)) {
            return redirect()->route('create-order');
        }

        return back()->with('error', 'username atau password salah!')->withInput();
    }

    public function logout()
    {
        Auth::logout();
        return redirect()->route('login');
    }
}
