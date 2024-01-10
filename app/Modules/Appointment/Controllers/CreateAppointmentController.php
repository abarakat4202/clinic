<?php

namespace App\Modules\Appointment\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\Appointment\Requests\CreateAppointmentRequest;
use App\Modules\Patient\Models\Patient;
use App\Modules\User\Models\User;

class CreateAppointmentController extends Controller
{
    public function __invoke(CreateAppointmentRequest $request)
    {
        return view('appointments.form', [
            'options' => [
                'patients' => Patient::get(['id', 'name as text']),
                'assignees' => User::whereHas('roles', fn ($q) => $q->where('is_assignable', true))
                    ->get(['id', 'name as text']),
            ]
        ]);
    }
}
