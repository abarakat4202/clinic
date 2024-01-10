<?php

namespace App\Modules\Permission\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\Permission\Models\Role;
use App\Modules\Permission\Requests\ListRolesRequest;
use App\Modules\Permission\Resources\RoleResource;
use App\Support\DatatableFilter;
use Illuminate\Database\Eloquent\Builder;

class ListRolesController extends Controller
{
    public function __construct()
    {
    }

    public function __invoke(ListRolesRequest $request)
    {
        if ($request->wantsJson()) {
            $roles = DatatableFilter::make(Role::class)->apply(
                $request->all(),
                fn (Builder $builder) => $builder->withCount('users')
            );

            return RoleResource::collection($roles);
        }

        return view('roles.list', [
            'totalRoles' => Role::query()->count(),
        ]);
    }
}
