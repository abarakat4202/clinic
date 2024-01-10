<?php

namespace App\Modules\Patient\Enums;

use App\Support\HasOptions;
use Illuminate\Contracts\Support\Arrayable;

enum PatientGender: int implements Arrayable
{
    use HasOptions;

    case Male = 1;
    case Female = 2;

    public function toString()
    {
        return match ($this) {
            default => ($this->name),
        };
    }
}
