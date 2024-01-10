<?php

namespace App\Modules\User\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ShowLoginFormController extends Controller
{
    public function __construct()
    {
        $this->middleware('guest');
    }

    public function __invoke(Request $request)
    {
        $pageConfigs = ['myLayout' => 'blank'];
        return view('users.auth.login', compact('pageConfigs'));
    }
}
