<?php

namespace App\Modules\Patient\Factories;

use App\Modules\Patient\Enums\PatientGender;
use App\Modules\Patient\Models\Patient;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<Patient>
 */
class PatientFactory extends Factory
{

    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Patient::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $gender = $this->faker->randomElement(PatientGender::cases());
        return [
            'name' => $this->fakeName($gender->toString()),
            'birth_date' => $this->faker->date,
            'gender' => $gender,
            'phone' => $this->fakePhone(),
            'emergency_name' => $emergencyName = $this->faker->optional()->name,
            'emergency_phone' => $emergencyName ? $this->fakePhone() : null,
            'address' => $this->faker->optional()->address,
            'medical_history' => $this->faker->optional()->text,
            'allergies' => $this->faker->optional()->text,
        ];
    }

    private function fakeName(string $gender): string
    {
        $firstName = fake('ar_EG')->firstName($gender);
        $lastName = fake('ar_EG')->lastName();
        return Str::slug(sprintf('%s %s', $firstName, $lastName), ' ');
    }

    private function fakePhone(): string
    {
        $prefixes = ['+2010', '+2011', '+2012', '+2015'];
        $pattern = Arr::random($prefixes) . '########';
        return $this->faker->unique()->numerify($pattern);
    }
}
