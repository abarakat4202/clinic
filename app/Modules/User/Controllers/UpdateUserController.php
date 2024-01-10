<?php

namespace App\Modules\User\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\User\Models\User;
use App\Modules\User\Requests\UpdateUserRequest;
use App\Modules\User\Services\UpdateUserService;
use Illuminate\Http\Request;

class UpdateUserController extends Controller
{
    public function __construct(protected UpdateUserService $service)
    {
    }

    public function __invoke(UpdateUserRequest $request, User $user)
    {
        $this->service->handle($user, $request->validated());

        return redirect()->route('users.index')->with([
            'success' => 'User has been updated successfully',
        ]);
    }
}
