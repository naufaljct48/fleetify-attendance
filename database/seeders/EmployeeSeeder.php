<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Employee;
use App\Models\Department;

class EmployeeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $departments = Department::all();

        $employees = [
            [
                'employee_id' => 'EMP001',
                'department_id' => $departments->where('department_name', 'Information Technology')->first()->id,
                'name' => 'Naufal Aziz A',
                'address' => 'Jl. Thamrin No. 456, Tangerang'
            ],
            [
                'employee_id' => 'EMP002',
                'department_id' => $departments->where('department_name', 'Human Resources')->first()->id,
                'name' => 'John Doe',
                'address' => 'Jl. Sudirman No. 123, Jakarta'
            ],
            [
                'employee_id' => 'EMP003',
                'department_id' => $departments->where('department_name', 'Finance')->first()->id,
                'name' => 'Bob Johnson',
                'address' => 'Jl. Gatot Subroto No. 789, Jakarta'
            ],
            [
                'employee_id' => 'EMP004',
                'department_id' => $departments->where('department_name', 'Marketing')->first()->id,
                'name' => 'Alice Brown',
                'address' => 'Jl. Kuningan No. 321, Jakarta'
            ],
            [
                'employee_id' => 'EMP005',
                'department_id' => $departments->where('department_name', 'Operations')->first()->id,
                'name' => 'Charlie Wilson',
                'address' => 'Jl. Senayan No. 654, Jakarta'
            ]
        ];

        foreach ($employees as $employee) {
            Employee::create($employee);
        }
    }
}
