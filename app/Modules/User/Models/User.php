<?php

namespace App\Modules\User\Models;

use App\Modules\Appointment\Models\Appointment;
use App\Modules\User\Enums\UserStatus;
use App\Modules\User\Factories\UserFactory;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Contracts\Database\Query\Builder as QueryBuilder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Carbon;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;


/**
 * @property int $id
 * @property string $name
 * @property string $email
 * @property ?Carbon $email_verified_at
 * @property UserStatus $status
 * @property string $password
 * @property Carbon $created_at
 * @property Carbon $updated_at
 * 
 * @property-read bool ?is_super_admin
 * @property-read Patient $patient
 * @property-read User $assignee
 * @property-read User $creator
 * 
 * @method static Builder active()
 */
class User extends Authenticatable implements MustVerifyEmail
{
    use HasFactory, Notifiable, HasRoles, HasApiTokens;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'status',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'status' => UserStatus::class,
    ];

    protected static function newFactory(): UserFactory
    {
        return UserFactory::new();
    }

    public function scopeActive(Builder $builder): Builder
    {
        return $builder->where('status', UserStatus::Active);
    }

    public function getIsSuperAdminAttribute(): bool
    {
        return $this->hasRole('super-admin');
    }

    public function assignedAppointments(): HasMany
    {
        return $this->hasMany(Appointment::class, 'assignee_id');
    }

    public function createdAppointments(): HasMany
    {
        return $this->hasMany(Appointment::class, 'creator_id');
    }
}
