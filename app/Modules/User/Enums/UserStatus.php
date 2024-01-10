<?php

namespace App\Modules\User\Enums;

use App\Support\HasOptions;
use Illuminate\Contracts\Support\Arrayable;

enum UserStatus: int implements Arrayable
{
    use HasOptions;

    case InActive = 0;
    case Active = 1;

    public function toString()
    {
        return match ($this) {
            static::InActive => 'inactive',
            static::Active => 'active',
            default => strtolower($this->name),
        };
    }
}
