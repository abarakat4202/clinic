<?php

namespace App\Modules\Permission\Services;

use App\Modules\Permission\Models\Role;

class DeleteRoleService
{

    public function __construct()
    {
    }

    public function handle(Role $role): bool
    {
        return (bool) $role->delete();
    }
}
