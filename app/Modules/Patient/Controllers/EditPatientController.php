<?php

namespace App\Modules\Patient\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\Patient\Enums\PatientGender;
use App\Modules\Patient\Models\Patient;
use App\Modules\Patient\Requests\EditPatientRequest;

class EditPatientController extends Controller
{
    public function __invoke(EditPatientRequest $request, Patient $patient)
    {
        return view('patients.form', [
            'patient' => $patient,
            'options' => [
                'genders' => PatientGender::cases(),
            ]
        ]);
    }
}
