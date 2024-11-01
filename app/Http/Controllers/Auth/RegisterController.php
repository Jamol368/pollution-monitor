<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\RegisterRequest;
use App\Services\Auth\RegisterService;
use Illuminate\Http\Request;

class RegisterController extends Controller
{
    public function showRegistrationForm(): \Illuminate\Contracts\View\View|\Illuminate\Contracts\View\Factory|\Illuminate\Foundation\Application
    {
        return view('auth.register');
    }

    public function register(RegisterRequest $request, RegisterService $registerService): \Illuminate\Http\RedirectResponse
    {
        $registerService->register($request->validated());

        return redirect()->route('login-form')->with('success', 'Registration successful.');
    }
}
