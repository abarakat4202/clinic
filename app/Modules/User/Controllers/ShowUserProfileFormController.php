<?php

namespace App\Modules\User\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ShowUserProfileFormController extends Controller
{
    public function __invoke(Request $request)
    {
        // dd(session()->all());
        return view('users.profile_form', [
            'user' => Auth::user(),
        ]);
    }
}
