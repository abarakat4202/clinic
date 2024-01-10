<?php

namespace App\Modules\Permission\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\Permission\Models\Role;
use App\Modules\Permission\Requests\UpdateRoleRequest;
use App\Modules\Permission\Services\UpdateRoleService;
use Illuminate\Http\Request;

class UpdateRoleController extends Controller
{
    public function __construct(protected UpdateRoleService $service)
    {
    }

    public function __invoke(UpdateRoleRequest $request, Role $role)
    {
        $this->service->handle($role, $request->validated());

        return redirect()->route('roles.index')->with([
            'success' => 'Role has been updated successfully',
        ]);
    }
}
