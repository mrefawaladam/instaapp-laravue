<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function showLoginPage()
    {
        return inertia('Login');
    }

    public function showRegisterPage()
    {
        return inertia('Register');
    }
 
    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            return redirect()->intended('/feed');
        }

        return back()->withErrors(['email' => 'Invalid credentials']);
    }
 
    public function register(Request $request)
    {
        $validated = $request->validate([
            'email' => 'required|email|unique:users',
            'name' => 'required',
            'password' => 'required|min:8|confirmed',
        ]);

        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
        ]);

        Auth::login($user);

        return redirect('/feed');
    }
}
