<?php

namespace App\Modules\User\Seeders;

use App\Modules\User\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::transaction(function () {
            $this->seedSuperAdmin();
            $users = User::factory()->count(10)->create();
            $users->each(
                fn (User $user) => $user->assignRole(fake()->boolean(80) ? 'doctor' : 'receptionist')
            );
        });
    }

    protected function seedSuperAdmin()
    {
        /** @var User */
        $superAdmin = User::firstOrCreate(['id' => 1], [
            'name' => 'Super Admin',
            'email' => 'admin@clinic.com',
            'password' => bcrypt('password'),
        ]);

        $superAdmin->assignRole(['super-admin']);
    }
}
