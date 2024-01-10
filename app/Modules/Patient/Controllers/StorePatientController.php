<?php

namespace App\Modules\Patient\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\Patient\Requests\StorePatientRequest;
use App\Modules\Patient\Services\StorePatientService;

class StorePatientController extends Controller
{
    public function __construct(protected StorePatientService $service)
    {
    }

    public function __invoke(StorePatientRequest $request)
    {
        $this->service->handle($request->validated());

        return redirect()->route('patients.index')->with([
            'success' => 'Patient has been added successfully',
        ]);
    }
}
