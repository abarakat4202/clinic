<?php

namespace App\Modules\Permission\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\Permission\Models\Role;
use App\Modules\Permission\Requests\DeleteRoleRequest;
use App\Modules\Permission\Services\DeleteRoleService;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class DeleteRoleController extends Controller
{
    public function __construct(protected DeleteRoleService $service)
    {
    }

    public function __invoke(DeleteRoleRequest $request, Role $role)
    {
        return response([
            'success' => $this->service->handle($role),
        ], Response::HTTP_NO_CONTENT);
    }
}
