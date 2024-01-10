<?php

namespace App\Modules\User\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\User\Models\User;
use App\Modules\User\Requests\DeleteUserRequest;
use App\Modules\User\Services\DeleteUserService;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class DeleteUserController extends Controller
{
    public function __construct(protected DeleteUserService $service)
    {
    }

    public function __invoke(DeleteUserRequest $request, User $user)
    {
        return response([
            'success' => $this->service->handle($user),
        ], Response::HTTP_NO_CONTENT);
    }
}
