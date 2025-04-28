<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Services\AuthService;

class AuthController extends Controller
{
    protected $authService;

    public function __construct(AuthService $authService)
    {
        $this->authService = $authService;
    }

    public function showLoginPage()
    {
        return inertia('Login');
    }

    public function showRegisterPage()
    {
        return inertia('Register');
    }

    public function login(LoginRequest $request)
    {
        $credentials = $request->validated();

        if ($this->authService->login($credentials)) {
            return redirect()->intended('/feed');
        }

        return back()->withErrors(['email' => 'Invalid credentials']);
    }

    public function register(RegisterRequest $request)
    {
        $validated = $request->validated();

        $this->authService->register($validated);

        return redirect('/feed');
    }

    public function logout(Request $request)
    {
        Auth::logout();  
        $request->session()->invalidate();
        
        $request->session()->regenerateToken();

        return redirect('/login'); 
    }
}