<?php

namespace App\Modules\Appointment\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\Appointment\Requests\StoreAppointmentRequest;
use App\Modules\Appointment\Services\StoreAppointmentService;
use Illuminate\Support\Carbon;

class StoreAppointmentController extends Controller
{
    public function __construct(protected StoreAppointmentService $service)
    {
    }

    public function __invoke(StoreAppointmentRequest $request)
    {
        $data = $request->validated();
        $data['estimated_start'] = Carbon::parse($data['appointment_date']);
        $data['estimated_end'] = $data['estimated_start']->clone()->addMinutes($data['duration']);
        $data['patient_id'] = $data['patient'];
        $data['assignee_id'] = $data['doctor'];

        $this->service->handle($data);

        return redirect()->to($request->redirect_to ?? '/appointments')->with([
            'success' => 'Appointment has been added successfully',
        ]);
    }
}
