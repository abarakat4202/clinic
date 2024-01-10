<?php

namespace App\Modules\Permission\Enums;

use App\Support\HasOptions;
use Illuminate\Contracts\Support\Arrayable;

enum UserPermission: string implements Arrayable
{
    use HasOptions;

    case UsersAdd = 'Users::add';
    case UsersEdit = 'Users::edit';
    case UsersDelete = 'Users::delete';
    case UsersView = 'Users::view';

    case RolesAdd = 'Roles::add';
    case RolesEdit = 'Roles::edit';
    case RolesDelete = 'Roles::delete';
    case RolesView = 'Roles::view';

    case PatientsAdd = 'Patients::add';
    case PatientsEdit = 'Patients::edit';
    case PatientsDelete = 'Patients::delete';
    case PatientsView = 'Patients::view';

    case AppointmentsAdd = 'Appointments::add';
    case AppointmentsEdit = 'Appointments::edit';
    case AppointmentsDelete = 'Appointments::delete';
    case AppointmentsView = 'Appointments::view';

    public function toString(): string
    {
        return ucwords(\Illuminate\Support\Str::of($this->name)->snake(' '));
    }

    public static function groups(): array
    {
        return array_reduce(static::cases(), function (array $groups, self $permission) {
            $permissionExploded = explode('::', $permission->value);
            $groupName = $permissionExploded[0];
            $groups[$groupName][] = $permission->value;
            return $groups;
        }, []);
    }
}
