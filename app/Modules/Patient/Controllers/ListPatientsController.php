<?php

namespace App\Modules\Patient\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\Patient\Enums\PatientGender;
use App\Modules\Patient\Models\Patient;
use App\Modules\Patient\Requests\ListPatientsRequest;
use App\Modules\Patient\Resources\PatientResource;
use App\Support\DatatableFilter;

class ListPatientsController extends Controller
{
    public function __construct()
    {
    }

    public function __invoke(ListPatientsRequest $request)
    {
        if ($request->wantsJson()) {
            $patients = DatatableFilter::make(Patient::class)->apply(
                $request->all()
            );

            return PatientResource::collection($patients);
        }

        return view('patients.list', [
            'totalPatients' => Patient::query()->count(),
            'options' => [
                'genders' => PatientGender::options(),
            ],
        ]);
    }
}
