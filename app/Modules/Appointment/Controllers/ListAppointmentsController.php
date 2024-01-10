<?php

namespace App\Modules\Appointment\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\Appointment\Enums\AppointmentStatus;
use App\Modules\Appointment\Models\Appointment;
use App\Modules\Appointment\Requests\ListAppointmentsRequest;
use App\Modules\Appointment\Resources\AppointmentResource;
use App\Modules\Patient\Models\Patient;
use App\Modules\User\Models\User;
use App\Support\DatatableFilter;
use Illuminate\Contracts\Database\Eloquent\Builder;

class ListAppointmentsController extends Controller
{
    public function __construct()
    {
    }

    public function __invoke(ListAppointmentsRequest $request)
    {
        if ($request->wantsJson()) {
            $appointments = DatatableFilter::make(Appointment::class)->apply(
                $request->all(),
                fn (Builder $builder) => $builder->with(['patient', 'assignee'])
            );

            return AppointmentResource::collection($appointments);
        }

        return view('appointments.list', [
            'totalAppointments' => Appointment::query()->count(),
            'options' => [
                'status' => AppointmentStatus::options(),
                'patients' => Patient::get(['id', 'name as text']),
                'assignees' => User::whereHas('roles', fn ($q) => $q->where('is_assignable', true))
                    ->get(['id', 'name as text']),
            ],
        ]);
    }
}
