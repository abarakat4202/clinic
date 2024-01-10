<?php

namespace App\Modules\User\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\Permission\Models\Role;
use App\Modules\User\Enums\UserStatus;
use App\Modules\User\Requests\CreateUserRequest;

class CreateUserController extends Controller
{
    public function __invoke(CreateUserRequest $request)
    {
        return view('users.form', [
            'options' => [
                'status' => UserStatus::cases(),
                'roles' => Role::notProtected()->orderBy('id')->pluck('name', 'id'),
            ]
        ]);
    }
}
