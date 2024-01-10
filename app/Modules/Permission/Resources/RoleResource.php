<?php

namespace App\Modules\Permission\Resources;

use App\Modules\Permission\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @mixin Role
 */
class RoleResource extends JsonResource
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
            'name' => ucwords($this->name),
            'is_assignable' => $this->is_assignable,
            'users_count' => $this->whenCounted('users'),
            'is_super_admin' => (bool) $this->is_protected,
        ];
    }
}
