<?php

namespace App\Support\Concerns;

trait HasOptions
{

    public static function options()
    {
        return array_map(
            fn (self $status) => $status->toArray(),
            static::cases()
        );
    }

    public function toArray(): array
    {
        return [
            'id' => $this->value,
            'text' => $this->toString(),
            'value' => $this->value,
            'name' => $this->name,
        ];
    }
}
