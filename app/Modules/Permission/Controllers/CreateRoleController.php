<?php

namespace App\Modules\Permission\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\Permission\Enums\UserPermission;
use App\Modules\Permission\Requests\CreateRoleRequest;

class CreateRoleController extends Controller
{
    public function __invoke(CreateRoleRequest $request)
    {
        return view('roles.form', [
            'options' => [
                'permissions' => UserPermission::groups(),
            ]
        ]);
    }
}
