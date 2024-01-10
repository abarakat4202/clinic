<?php

namespace App\Modules\Appointment\Factories;

use App\Modules\Appointment\Enums\AppointmentStatus;
use App\Modules\Appointment\Models\Appointment;
use App\Modules\Patient\Models\Patient;
use App\Modules\User\Models\User;
use Carbon\CarbonImmutable;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<Appointment>
 */
class AppointmentFactory extends Factory
{

    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Appointment::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $estimatedStart = CarbonImmutable::parse($this->faker->dateTimeBetween('now', '+7 days'));
        $estimatedEnd = $estimatedStart->addMinutes(30);

        return [
            'patient_id' => Patient::factory(),
            'assignee_id' => User::factory(),
            'creator_id' => User::factory(),
            'estimated_start' => $estimatedStart,
            'estimated_end' => $estimatedEnd,
            'status' => $this->faker->randomElement(AppointmentStatus::cases()),
            'diagnosis' => $this->faker->optional()->text,
            'procedures' => $this->faker->optional()->text,
            'prescription' => $this->faker->optional()->text,
        ];
    }
}
