<?php

namespace App\Modules\User\Resources;

use App\Modules\User\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @mixin User
 */
class UserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'email' => $this->email,
            'status' => $this->status,
            $this->mergeWhen($this->relationLoaded('roles'), fn () => [
                'roles' => $this->roles->pluck('name')->map(fn (string $name) => ucfirst($name))->implode(','),
                'is_super_admin' => $this->is_super_admin,
            ]),
        ];
    }
}
