<?php

namespace App\Http\Controllers\pages;

use App\Http\Controllers\Controller;
use App\Modules\Appointment\Models\Appointment;
use App\Modules\Patient\Models\Patient;
use App\Modules\User\Models\User;

class HomePage extends Controller
{
    public function index()
    {
        $appointmentsCount = Appointment::count();
        $usersCount = User::count();
        $patientsCount = Patient::count();
        $appointments = Appointment::open()
            ->whereDate('estimated_start', today())
            ->orderBy('estimated_start')
            ->with(['patient', 'assignee', 'creator'])
            ->paginate(20);

        return view('content.pages.pages-home', compact(
            'appointments',
            'appointmentsCount',
            'usersCount',
            'patientsCount',
        ));
    }
}
