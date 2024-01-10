<?php

namespace App\Modules\Appointment\Models;

use App\Modules\Appointment\Enums\AppointmentStatus;
use App\Modules\Appointment\Factories\AppointmentFactory;
use App\Modules\Patient\Models\Patient;
use App\Modules\User\Models\User;
use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Contracts\Database\Query\Builder as QueryBuilder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Carbon;

/**
 * @property int $id
 * @property int $patient_id
 * @property int $assignee_id
 * @property int $creator_id
 * @property Carbon $estimated_start
 * @property Carbon $estimated_end
 * @property AppointmentStatus $status
 * @property ?string $diagnosis
 * @property ?string $procedures
 * @property ?string $prescription
 * @property Carbon $created_at
 * @property Carbon $updated_at
 *
 * @property-read ?int $estimated_duration
 * @property-read bool $is_closed
 * @property-read Patient $patient
 * @property-read User $assignee
 * @property-read User $creator

 * @method static Builder open()
 * @method static Builder withinTimes(Carbon $start, Carbon $end, ?Appointment $ignore = null)
 */
class Appointment extends Model
{
    use HasFactory;

    protected $fillable = [
        'patient_id',
        'assignee_id',
        'creator_id',
        'estimated_start',
        'estimated_end',
        'status',
        'diagnosis',
        'procedures',
        'prescription',
    ];

    protected $casts = [
        'status' => AppointmentStatus::class,
        'estimated_start' => 'datetime',
        'estimated_end' => 'datetime',
    ];

    protected static function newFactory(): AppointmentFactory
    {
        return AppointmentFactory::new();
    }

    public function patient(): BelongsTo
    {
        return $this->belongsTo(Patient::class);
    }

    public function assignee(): BelongsTo
    {
        return $this->belongsTo(User::class, 'assignee_id');
    }

    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'creator_id');
    }

    public function scopeOpen(Builder $builder): Builder
    {
        return $builder->whereNotIn('status', [
            AppointmentStatus::Cancelled,
            AppointmentStatus::Completed,
        ]);
    }

    public function scopeWithinTimes(Builder $builder, Carbon $start, Carbon $end, ?Appointment $ignore = null): Builder
    {
        $builder->open()->where(
            fn (QueryBuilder $q) => $q->whereBetween('estimated_start', [$start, $end])
                ->orWhereBetween('estimated_end', [$start, $end])
        );

        if ($ignore) {
            $builder->where('id', '!=', $ignore->id);
        }

        return $builder;
    }

    public function getIsClosedAttribute(): bool
    {
        return in_array($this->status, [
            AppointmentStatus::Cancelled,
            AppointmentStatus::Completed,
        ]);
    }

    public function getEstimatedDurationAttribute(): ?int
    {
        if (empty($this->estimated_end) || empty($this->estimated_start)) {
            return null;
        }
        return $this->estimated_end->diffInMinutes($this->estimated_start);
    }
}
