<?php

namespace App\Modules\Patient\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\Patient\Enums\PatientGender;
use App\Modules\Patient\Requests\CreatePatientRequest;

class CreatePatientController extends Controller
{
    public function __invoke(CreatePatientRequest $request)
    {
        return view('patients.form', [
            'options' => [
                'genders' => PatientGender::cases(),
            ]
        ]);
    }
}
