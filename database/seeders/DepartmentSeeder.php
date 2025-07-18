<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Department;

class DepartmentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $departments = [
            [
                'department_name' => 'Human Resources',
                'max_clock_in_time' => '09:00',
                'max_clock_out_time' => '17:00'
            ],
            [
                'department_name' => 'Information Technology',
                'max_clock_in_time' => '08:30',
                'max_clock_out_time' => '17:30'
            ],
            [
                'department_name' => 'Finance',
                'max_clock_in_time' => '08:00',
                'max_clock_out_time' => '17:00'
            ],
            [
                'department_name' => 'Marketing',
                'max_clock_in_time' => '09:00',
                'max_clock_out_time' => '18:00'
            ],
            [
                'department_name' => 'Operations',
                'max_clock_in_time' => '07:30',
                'max_clock_out_time' => '16:30'
            ]
        ];

        foreach ($departments as $department) {
            Department::create($department);
        }
    }
}
