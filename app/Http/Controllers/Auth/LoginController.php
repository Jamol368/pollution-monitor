<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Http\Requests\Auth\LogoutRequest;
use App\Services\Auth\LoginService;
use App\Services\Auth\LogoutService;

class LoginController extends Controller
{
    public function showLoginForm(): \Illuminate\Contracts\View\View|\Illuminate\Contracts\View\Factory|\Illuminate\Foundation\Application
    {
        return view('auth.login');
    }

    public function login(LoginRequest $request, LoginService $loginService): \Illuminate\Http\RedirectResponse
    {
        if ($loginService->login($request->validated())) {
            return redirect()->route('dashboard');
        }

        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ]);
    }

    public function logout(LogoutRequest $request, LogoutService $logoutService): \Illuminate\Foundation\Application|\Illuminate\Routing\Redirector|\Illuminate\Http\RedirectResponse
    {
        $logoutService->logout($request);

        return redirect()->route('login-form')
            ->with('success', 'You have been logged out successfully.');
    }

}
