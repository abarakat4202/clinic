<?php

namespace App\Modules\User\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LogoutUserController extends Controller
{
    public function __invoke(Request $request)
    {
        Auth::logoutCurrentDevice();
        return redirect('/');
    }
}
