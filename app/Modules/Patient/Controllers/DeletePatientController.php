<?php

namespace App\Modules\Patient\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\Patient\Models\Patient;
use App\Modules\Patient\Requests\DeletePatientRequest;
use App\Modules\Patient\Services\DeletePatientService;
use Illuminate\Http\Response;

class DeletePatientController extends Controller
{
    public function __construct(protected DeletePatientService $service)
    {
    }

    public function __invoke(DeletePatientRequest $request, Patient $patient)
    {
        return response([
            'success' => $this->service->handle($patient),
        ], Response::HTTP_NO_CONTENT);
    }
}
