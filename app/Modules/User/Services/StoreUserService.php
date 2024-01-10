<?php

namespace App\Modules\User\Services;

use App\Modules\User\Models\User;
use Illuminate\Support\Facades\DB;

class StoreUserService
{

    public function __construct()
    {
    }

    public function handle(array $data): User
    {
        return DB::transaction(function () use ($data) {
            $data['password'] = bcrypt($data['password']);
            $data['roles'] = array_map(fn ($r) => (int)$r, $data['roles']);

            /** @var User */
            $user = User::create($data);
            $user->assignRole($data['roles']);
            return $user;
        });
    }
}
