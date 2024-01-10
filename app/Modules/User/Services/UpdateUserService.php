<?php

namespace App\Modules\User\Services;

use App\Modules\User\Models\User;
use Illuminate\Support\Facades\DB;

class UpdateUserService
{

    public function __construct()
    {
    }

    public function handle(User $user, array $data): bool
    {
        return DB::transaction(function () use ($user, $data) {

            if (empty($data['password'])) {
                unset($data['password']);
            }
            $user->update($data);

            if (!empty($data['roles'])) {
                $data['roles'] = array_map(fn ($r) => (int)$r, $data['roles']);
                $user->syncRoles($data['roles']);
            }

            return true;
        });
    }
}
