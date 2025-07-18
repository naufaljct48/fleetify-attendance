<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        // Create default admin user
        User::factory()->create([
            'name' => 'Admin User',
            'email' => 'admin@fleetify.id',
            'password' => bcrypt('password')
        ]);

        // Seed departments and employees
        $this->call([
            DepartmentSeeder::class,
            EmployeeSeeder::class,
            AttendanceSeeder::class,
        ]);
    }
}
