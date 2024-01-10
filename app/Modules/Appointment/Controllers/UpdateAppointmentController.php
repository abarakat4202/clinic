<?php

namespace App\Modules\Appointment\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\Appointment\Models\Appointment;
use App\Modules\Appointment\Requests\UpdateAppointmentRequest;
use App\Modules\Appointment\Services\UpdateAppointmentService;
use Illuminate\Support\Carbon;

class UpdateAppointmentController extends Controller
{
    public function __construct(protected UpdateAppointmentService $service)
    {
    }

    public function __invoke(UpdateAppointmentRequest $request, Appointment $appointment)
    {
        $data = $request->validated();
        $data['estimated_start'] = Carbon::parse($data['appointment_date']);
        $data['estimated_end'] = $data['estimated_start']->clone()->addMinutes($data['duration']);
        $data['assignee_id'] = $data['doctor'];

        $this->service->handle($appointment, $data);

        return redirect()->to($request->redirect_to ?? '/appointments')->with([
            'success' => 'Appointment has been updated successfully',
        ]);
    }
}
