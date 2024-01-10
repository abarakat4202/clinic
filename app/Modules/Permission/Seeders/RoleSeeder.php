<?php

namespace App\Modules\Permission\Seeders;

use App\Modules\Permission\Enums\UserPermission;
use Illuminate\Database\Seeder;
use App\Modules\Permission\Models\Role;
use Illuminate\Support\Facades\DB;
use Throwable;

class RoleSeeder extends Seeder
{
    public function run(): void
    {
        $defaultRoles = [
            ['id' => 1, 'name' => 'super-admin', 'is_assignable' => false, 'is_protected' => true, 'guard_name' => 'web'],
            ['id' => 2, 'name' => 'doctor', 'is_assignable' => true, 'is_protected' => false, 'guard_name' => 'web'],
            ['id' => 3, 'name' => 'receptionist', 'is_assignable' => false, 'is_protected' => false, 'guard_name' => 'web'],
        ];

        DB::beginTransaction();

        try {
            Role::insertOrIgnore($defaultRoles);

            //Super Admin permissions
            Role::findByName('super-admin')->givePermissionTo(UserPermission::cases());

            //Doctor permissions
            Role::findByName('doctor')->givePermissionTo([
                UserPermission::PatientsView,
                UserPermission::AppointmentsEdit,
                UserPermission::AppointmentsView,
            ]);

            //Receptionist permissions
            Role::findByName('receptionist')->givePermissionTo([
                UserPermission::PatientsAdd,
                UserPermission::PatientsEdit,
                UserPermission::PatientsView,
                UserPermission::AppointmentsAdd,
                UserPermission::AppointmentsEdit,
                UserPermission::AppointmentsView,
            ]);

            DB::commit();
        } catch (Throwable $e) {
            DB::rollBack();
            throw $e;
        }
    }
}
