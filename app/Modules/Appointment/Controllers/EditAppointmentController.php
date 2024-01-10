<?php

namespace App\Modules\Appointment\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\Appointment\Enums\AppointmentGender;
use App\Modules\Appointment\Enums\AppointmentStatus;
use App\Modules\Appointment\Models\Appointment;
use App\Modules\Appointment\Requests\EditAppointmentRequest;
use App\Modules\Patient\Models\Patient;
use App\Modules\User\Models\User;

class EditAppointmentController extends Controller
{
    public function __invoke(EditAppointmentRequest $request, Appointment $appointment)
    {
        return view('appointments.form', [
            'appointment' => $appointment,
            'options' => [
                'patients' => Patient::get(['id', 'name as text']),
                'assignees' => User::whereHas('roles', fn ($q) => $q->where('is_assignable', true))
                    ->get(['id', 'name as text']),
                'status' => AppointmentStatus::options(),
            ]
        ]);
    }
}
