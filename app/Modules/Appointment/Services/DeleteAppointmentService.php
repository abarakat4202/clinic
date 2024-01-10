<?php

namespace App\Modules\Appointment\Services;

use App\Modules\Appointment\Models\Appointment;

class DeleteAppointmentService
{

    public function __construct()
    {
    }

    public function handle(Appointment $appointment): bool
    {
        return (bool) $appointment->delete();
    }
}
