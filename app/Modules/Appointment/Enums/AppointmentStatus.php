<?php

namespace App\Modules\Appointment\Enums;

use App\Support\HasOptions;
use Illuminate\Contracts\Support\Arrayable;

enum AppointmentStatus: int implements Arrayable
{
    use HasOptions;

    case Missed = -1;
    case Cancelled = 0;
    case Pending = 1;
    case Confirmed = 2;
    case Rescheduled = 3;
    case InProgress = 4;
    case Completed = 5;

    public function toString()
    {
        return match ($this) {
            default => ucwords(\Illuminate\Support\Str::of($this->name)->snake(' ')),
        };
    }
}
