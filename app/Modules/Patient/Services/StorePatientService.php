<?php

namespace App\Modules\Patient\Services;

use App\Modules\Patient\Models\Patient;

class StorePatientService
{

    public function __construct()
    {
    }

    public function handle(array $data): Patient
    {
        return Patient::create($data);
    }
}
