<?php

namespace App\Modules\Patient\Services;

use App\Modules\Patient\Models\Patient;
use App\Modules\Permission\Models\Role;
use Illuminate\Support\Facades\DB;

class UpdatePatientService
{

    public function __construct()
    {
    }

    public function handle(Patient $patient, array $data): bool
    {
        return $patient->update($data);
    }
}
