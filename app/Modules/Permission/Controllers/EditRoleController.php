<?php

namespace App\Modules\Permission\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\Permission\Enums\RoleStatus;
use App\Modules\Permission\Enums\UserPermission;
use App\Modules\Permission\Models\Role;
use App\Modules\Permission\Requests\EditRoleRequest;

class EditRoleController extends Controller
{
    public function __invoke(EditRoleRequest $request, Role $role)
    {
        return view('roles.form', [
            'role' => $role,
            'options' => [
                'permissions' => UserPermission::groups(),
            ]
        ]);
    }
}
