<?php

namespace App\Services\Auth;

use App\Models\User;

class RegisterService
{
    public function register(array $data): User
    {
        return User::create($data);
    }
}
