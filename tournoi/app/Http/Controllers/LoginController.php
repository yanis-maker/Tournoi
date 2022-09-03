<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class LoginController extends Controller
{
    public function login()
    {
        return view('pages.login');
    }

    public function authenticate(Request $request)
    {
        $data = $request->validate([
            'email' => 'required|email',
            'password' => 'required|min:8',
        ]);

        $remember = $request->has('remember') ? true : false;

        if (Auth::attempt(['email' => $data['email'], 'password' => $data['password']], $remember)) {
            $request->session()->regenerate();
            return redirect()->intended('dashboard');
        }

        return back()->with([
            'error' => 'Email ne correspond à aucun compte',
        ]);
    }

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect()->route('home');
    }

    public function dashboard()
    {
        $permission = Auth::user()->permission;
        switch ($permission) {
            case 0:
                return redirect()->route('dashboard-captain');
                break;
            case 1:
                return redirect()->route('dashboard-gestion');
                break;
            case 2:
                return redirect()->route('dashboard-admin');
                break;
        }
    }
}
