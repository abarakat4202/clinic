<?php

namespace App\Modules\Appointment\Services;

use App\Modules\Appointment\Models\Appointment;

class UpdateAppointmentService
{

    public function __construct()
    {
    }

    public function handle(Appointment $appointment, array $data): bool
    {
        return $appointment->update($data);
    }
}
