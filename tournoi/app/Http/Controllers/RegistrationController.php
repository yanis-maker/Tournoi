<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use App\Models\User;

class RegistrationController extends Controller
{
    public function create()
    {
        return view('pages.registration');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'username' => 'required|min:8',
            'email' => 'required|email|unique:App\Models\User,email',
            'password' => 'required|confirmed|min:8',
        ]);

        $user = User::create([
            'username' => $data['username'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
        ]);

        return redirect()->route('login')->with('success','Votre compte a bien été enregistré créé');
    }
}
