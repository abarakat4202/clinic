<?php

namespace App\Modules\Patient\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\Appointment\Enums\AppointmentStatus;
use App\Modules\Patient\Models\Patient;
use App\Modules\Patient\Requests\ShowPatientRequest;
use App\Modules\User\Models\User;

class ShowPatientController extends Controller
{
    public function __invoke(ShowPatientRequest $request, Patient $patient)
    {
        $patient->loadMissing(['incomingAppointment', 'appointments.assignee', 'appointments.creator']);
        $appointments = $patient->appointments;
        $incomingAppointment = $patient->incomingAppointment;
        return view('patients.show', [
            'patient' => $patient,
            'appointments' => $appointments,
            'incomingAppointment' => $incomingAppointment,
            'options' => [
                'patients' => Patient::get(['id', 'name as text']),
                'assignees' => User::whereHas('roles', fn ($q) => $q->where('is_assignable', true))
                    ->get(['id', 'name as text']),
                'status' => AppointmentStatus::options(),
            ]
        ]);
    }
}
