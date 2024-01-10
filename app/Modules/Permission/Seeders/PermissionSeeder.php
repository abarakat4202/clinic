<?php

namespace App\Modules\Permission\Seeders;

use Illuminate\Database\Seeder;
use App\Modules\Permission\Models\Permission;
use App\Modules\Permission\Enums\UserPermission;

class PermissionSeeder extends Seeder
{
    public function run(): void
    {
        $this->seed(array_column(UserPermission::cases(), 'value'), 'web');
    }

    public function seed(array $permissions, string $guardName)
    {
        $existing = Permission::whereIn('name', $permissions)->whereGuardName($guardName)->pluck('name')->toArray();
        $newPermissions = array_diff($permissions, $existing);

        $newPermissions = array_map(fn ($permission) => [
            'name' => $permission,
            'guard_name' => $guardName,
            'created_at' => now(),
            'updated_at' => now(),
        ], $newPermissions);

        Permission::insert($newPermissions);
    }
}
