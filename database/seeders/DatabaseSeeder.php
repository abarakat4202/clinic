<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Modules\Appointment\Models\Appointment;
use App\Modules\Patient\Models\Patient;
use App\Modules\Permission\Seeders\PermissionSeeder;
use App\Modules\Permission\Seeders\RoleSeeder;
use App\Modules\User\Models\User;
use App\Modules\User\Seeders\UserSeeder;
use Illuminate\Database\Seeder;
use Spatie\Permission\PermissionRegistrar;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Reset cached roles and permissions
        app()[PermissionRegistrar::class]->forgetCachedPermissions();

        $this->call(PermissionSeeder::class);
        $this->call(RoleSeeder::class);
        $this->call(UserSeeder::class);

        Patient::factory(100)->create();

        $this->recursiveCreateAppointments();
    }

    protected function recursiveCreateAppointments(): void
    {
        // Base Case
        if (Appointment::count() >= 100) {
            return;
        }

        // Decomposition
        Appointment::factory()
            ->for(User::role('doctor')->inRandomOrder()->first(), 'assignee')
            ->for(User::role('receptionist')->inRandomOrder()->first(), 'creator')
            ->for(Patient::inRandomOrder()->first())
            ->create();

        // Composition
        $this->recursiveCreateAppointments();
    }
}
