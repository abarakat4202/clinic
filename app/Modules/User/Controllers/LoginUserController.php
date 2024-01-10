<?php

namespace App\Modules\User\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\User\Requests\LoginUserRequest;
use App\Modules\User\Services\LoginUserService;

class LoginUserController extends Controller
{
    public function __construct(protected LoginUserService $service)
    {
        $this->middleware('guest');
    }

    public function __invoke(LoginUserRequest $request)
    {
        $isLoggedIn = $this->service->handle(...$request->only([
            'email',
            'password',
            'remember',
        ]));

        if ($isLoggedIn) {
            return redirect()->intended('/');
        }

        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ])->onlyInput('email');
    }
}
