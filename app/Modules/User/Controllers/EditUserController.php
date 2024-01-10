<?php

namespace App\Modules\User\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\Permission\Models\Role;
use App\Modules\User\Enums\UserStatus;
use App\Modules\User\Models\User;
use App\Modules\User\Requests\EditUserRequest;

class EditUserController extends Controller
{
    public function __invoke(EditUserRequest $request, User $user)
    {
        return view('users.form', [
            'user' => $user,
            'options' => [
                'status' => UserStatus::cases(),
                'roles' => Role::notProtected()->orderBy('id')->pluck('name', 'id'),
            ]
        ]);
    }
}
