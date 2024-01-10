<?php

namespace App\Modules\User\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\User\Requests\StoreUserRequest;
use App\Modules\User\Services\StoreUserService;

class StoreUserController extends Controller
{
    public function __construct(protected StoreUserService $service)
    {
    }

    public function __invoke(StoreUserRequest $request)
    {
        $this->service->handle($request->validated());

        return redirect()->route('users.index')->with([
            'success' => 'User has been created successfully',
        ]);
    }
}
