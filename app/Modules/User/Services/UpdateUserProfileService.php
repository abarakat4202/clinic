<?php

namespace App\Modules\User\Services;

use Illuminate\Support\Facades\Auth;

class UpdateUserProfileService
{

    public function __construct()
    {
    }

    public function handle(array $data): bool
    {
        $data = array_filter($data);

        if (empty($data)) {
            return false;
        }

        if (!empty($data['password'])) {
            $data['password'] = bcrypt($data['password']);
        }

        return Auth::user()->update($data);
    }
}
