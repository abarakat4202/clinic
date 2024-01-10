<?php

namespace App\Http\Controllers\pages;

use App\Http\Controllers\Controller;
use App\Modules\Appointment\Models\Appointment;
use App\Modules\Patient\Models\Patient;
use App\Modules\Permission\Models\Role;
use App\Modules\User\Models\User;
use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;

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
            ->when(
                Auth::user()->hasExactRoles(Role::Assignable()->pluck('name')),
                fn (Builder $q) => $q->where('assignee_id', Auth::id())
            )
            ->paginate(20);

        return view('content.pages.pages-home', compact(
            'appointments',
            'appointmentsCount',
            'usersCount',
            'patientsCount',
        ));
    }
}
