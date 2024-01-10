<?php

namespace App\Modules\Patient\Models;

use App\Modules\Appointment\Models\Appointment;
use App\Modules\Patient\Enums\PatientGender;
use App\Modules\Patient\Factories\PatientFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Support\Carbon;

/**
 * @property int $id
 * @property string $name
 * @property Carbon $birth_date
 * @property PatientGender $gender
 * @property string $phone
 * @property ?string $emergency_name
 * @property ?string $emergency_phone
 * @property ?string $address
 * @property ?string $medical_history
 * @property ?string $allergies
 * @property Carbon $created_at
 * @property Carbon $updated_at
 * 
 * @property-read int $age
 * @property-read int $incomingAppointment
 * @property-read int $appointments
 */
class Patient extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'birth_date',
        'gender',
        'phone',
        'emergency_name',
        'emergency_phone',
        'address',
        'medical_history',
        'allergies',
    ];

    protected $casts = [
        'gender' => PatientGender::class,
        'birth_date' => 'date',
    ];

    protected static function newFactory(): PatientFactory
    {
        return PatientFactory::new();
    }

    public function getAgeAttribute(): int
    {
        return $this->birth_date->diffInYears(Carbon::now());
    }

    public function incomingAppointment(): HasOne
    {
        return $this->hasOne(Appointment::class)
            ->whereDate('estimated_start', '>=', now());
    }

    public function appointments(): HasMany
    {
        return $this->hasMany(Appointment::class);
    }
}
