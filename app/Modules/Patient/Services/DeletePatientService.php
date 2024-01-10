<?php

namespace App\Modules\Patient\Services;

use App\Modules\Patient\Models\Patient;

class DeletePatientService
{

    public function __construct()
    {
    }

    public function handle(Patient $patient): bool
    {
        return (bool) $patient->delete();
    }
}
