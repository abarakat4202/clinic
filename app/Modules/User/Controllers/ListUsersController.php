<?php

namespace App\Modules\User\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\Permission\Models\Role;
use App\Modules\User\Enums\UserStatus;
use App\Modules\User\Models\User;
use App\Modules\User\Requests\ListUsersRequest;
use App\Modules\User\Resources\UserResource;
use App\Support\DatatableFilter;
use Illuminate\Database\Eloquent\Builder;

class ListUsersController extends Controller
{
    public function __construct()
    {
    }

    public function __invoke(ListUsersRequest $request)
    {
        if ($request->wantsJson()) {
            $users = DatatableFilter::make(User::class)->apply(
                $request->all(),
                fn (Builder $builder) => $builder->with('roles')
            );
            return UserResource::collection($users);
        }

        return view('users.list', [
            'totalUsers' => User::query()->count(),
            'activeUsers' => User::query()->active()->count(),
            'options' => [
                'status' => UserStatus::cases(),
                'roles' => Role::notProtected()->orderBy('id')->pluck('name', 'id'),
            ],
        ]);
    }
}
