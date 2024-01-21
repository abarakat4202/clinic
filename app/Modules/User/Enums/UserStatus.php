<?php

namespace App\Modules\User\Enums;

use App\Support\Concerns\HasOptions;
use Illuminate\Contracts\Support\Arrayable;

enum UserStatus: int implements Arrayable
{
    use HasOptions;

    case InActive = 0;
    case Active = 1;

    public function toString()
    {
        return match ($this) {
            static::InActive => 'Inactive',
            static::Active => 'Active',
            default => strtolower($this->name),
        };
    }
}
