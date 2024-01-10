<?php

namespace App\Modules\Appointment\Services;

use App\Modules\Appointment\Models\Appointment;
use Illuminate\Support\Facades\Auth;

class StoreAppointmentService
{

    public function __construct()
    {
    }

    public function handle(array $data): Appointment
    {
        if (empty($data['creator_id'])) {
            $data['creator_id'] = Auth::id();
        }

        return Appointment::create($data);
    }
}
