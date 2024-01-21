<?php

namespace App\Modules\User\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\User\Requests\UpdateUserProfileRequest;
use App\Modules\User\Services\UpdateUserProfileService;
use Illuminate\Http\Request;

class UpdateUserProfileController extends Controller
{
    public function __construct(protected UpdateUserProfileService $service)
    {
    }

    public function __invoke(UpdateUserProfileRequest $request)
    {
        $isUpdated = $this->service->handle($request->validated());

        if (!$isUpdated) {
            return redirect()->route('users.profile.edit')->with([
                'message' => 'No Updates!',
                'alert-class' => 'alert-warning',
            ]);
        }

        return redirect()->route('users.profile.edit')->with([
            'success' => 'Account has been updated successfully',
        ]);
    }
}
