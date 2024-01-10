<?php

namespace App\Modules\Permission\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\Permission\Requests\StoreRoleRequest;
use App\Modules\Permission\Services\StoreRoleService;

class StoreRoleController extends Controller
{
    public function __construct(protected StoreRoleService $service)
    {
    }

    public function __invoke(StoreRoleRequest $request)
    {
        $this->service->handle($request->validated());

        return redirect()->route('roles.index')->with([
            'success' => 'Role has been created successfully',
        ]);
    }
}
