<?php

namespace App\Modules\Patient\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\Patient\Models\Patient;
use App\Modules\Patient\Requests\UpdatePatientRequest;
use App\Modules\Patient\Services\UpdatePatientService;

class UpdatePatientController extends Controller
{
    public function __construct(protected UpdatePatientService $service)
    {
    }

    public function __invoke(UpdatePatientRequest $request, Patient $patient)
    {
        $this->service->handle($patient, $request->validated());

        return redirect()->route('patients.index')->with([
            'success' => 'Patient has been updated successfully',
        ]);
    }
}
