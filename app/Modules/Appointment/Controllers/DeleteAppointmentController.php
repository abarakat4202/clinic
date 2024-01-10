<?php

namespace App\Modules\Appointment\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\Appointment\Models\Appointment;
use App\Modules\Appointment\Requests\DeleteAppointmentRequest;
use App\Modules\Appointment\Services\DeleteAppointmentService;
use Illuminate\Http\Response;

class DeleteAppointmentController extends Controller
{
    public function __construct(protected DeleteAppointmentService $service)
    {
    }

    public function __invoke(DeleteAppointmentRequest $request, Appointment $appointment)
    {
        return response([
            'success' => $this->service->handle($appointment),
        ], Response::HTTP_NO_CONTENT);
    }
}
