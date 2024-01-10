<?php

namespace App\Modules\Appointment\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\Appointment\Models\Appointment;
use App\Modules\Appointment\Requests\ShowAppointmentRequest;

class ShowAppointmentController extends Controller
{
    public function __invoke(ShowAppointmentRequest $request, Appointment $appointment)
    {
        $appointment->loadMissing(['creator', 'assignee', 'patient']);
        return view('appointments.show', compact('appointment'));
    }
}
