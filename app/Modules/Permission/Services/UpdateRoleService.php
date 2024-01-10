<?php

namespace App\Modules\Permission\Services;

use App\Modules\Permission\Models\Role;
use Illuminate\Support\Facades\DB;

class UpdateRoleService
{

    public function __construct()
    {
    }

    public function handle(Role $role, array $data): bool
    {
        return DB::transaction(function () use ($role, $data) {
            $data['guard_name'] = 'web';

            /** @var Role */
            $role->update($data);
            $role->givePermissionTo($data['permissions']);
            return true;
        });
    }
}
