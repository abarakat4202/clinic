<?php

namespace App\Modules\Permission\Models;

use Illuminate\Contracts\Database\Eloquent\Builder;
use Spatie\Permission\Models\Role as SpatieRole;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * @property string $name
 * @property string $guard_name
 * @property bool $is_assignable
 * @property bool $is_protected
 * @property ?\Illuminate\Support\Carbon $created_at
 * @property ?\Illuminate\Support\Carbon $updated_at
 * 
 * @method static Builder notProtected()
 */
class Role extends SpatieRole
{
    use HasFactory;

    protected $fillable = [
        'name',
        'guard_name',
        'is_assignable',
        'is_protected',
    ];

    protected $casts = [
        'is_assignable' => 'bool',
        'is_protected' => 'bool',
    ];

    public function scopeAssignable(Builder $builder): Builder
    {
        return $builder->where('is_assignable', true);
    }

    public function scopeNotProtected(Builder $builder): Builder
    {
        return $builder->where('is_protected', '!=', true);
    }
}
