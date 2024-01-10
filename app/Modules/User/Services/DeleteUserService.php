<?php

namespace App\Modules\User\Services;

use App\Modules\User\Models\User;

class DeleteUserService
{

    public function __construct()
    {
    }

    public function handle(User $user): bool
    {
        return (bool) $user->delete();
    }
}
