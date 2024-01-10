<?php

namespace App\Modules\Permission\Services;

use App\Modules\Permission\Models\Role;
use Illuminate\Support\Facades\DB;

class StoreRoleService
{

    public function __construct()
    {
    }

    public function handle(array $data): Role
    {
        return DB::transaction(function () use ($data) {
            $data['guard_name'] = 'web';

            /** @var Role */
            $role = Role::create($data);
            $role->givePermissionTo($data['permissions']);
            return $role;
        });
    }
}
