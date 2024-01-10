<?php

namespace App\Modules\User\Services;

use Illuminate\Support\Facades\Auth;

class LoginUserService
{

    public function __construct()
    {
        
    }

    public function handle(string $email, string $password, bool $remember = false): bool
    {
        if (Auth::attempt(['email' => $email, 'password' => $password], $remember)) {
            request()->session()->regenerate();
            return true;
        }

        return false;
    }
}