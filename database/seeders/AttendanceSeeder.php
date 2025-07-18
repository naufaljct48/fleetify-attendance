<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Attendance;
use App\Models\AttendanceHistory;
use App\Models\Employee;
use Carbon\Carbon;

class AttendanceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $employees = Employee::all();

        // Create sample attendance for today
        foreach ($employees->take(3) as $index => $employee) {
            $clockIn = Carbon::today()->addHours(8)->addMinutes($index * 15); // 08:00, 08:15, 08:30
            $clockOut = $clockIn->copy()->addHours(8)->addMinutes(30); // 8.5 hours later

            $attendanceId = 'ATT-' . Carbon::today()->format('Ymd') . '-' . str_pad($index + 1, 3, '0', STR_PAD_LEFT);

            $attendance = Attendance::create([
                'employee_id' => $employee->employee_id,
                'attendance_id' => $attendanceId,
                'clock_in' => $clockIn,
                'clock_out' => $clockOut
            ]);

            // Create attendance history for clock in
            AttendanceHistory::create([
                'employee_id' => $employee->employee_id,
                'attendance_id' => $attendanceId,
                'date_attendance' => $clockIn,
                'attendance_type' => AttendanceHistory::TYPE_CLOCK_IN,
                'description' => 'Employee checked in'
            ]);

            // Create attendance history for clock out
            AttendanceHistory::create([
                'employee_id' => $employee->employee_id,
                'attendance_id' => $attendanceId,
                'date_attendance' => $clockOut,
                'attendance_type' => AttendanceHistory::TYPE_CLOCK_OUT,
                'description' => 'Employee checked out'
            ]);
        }

        // Create sample attendance for yesterday
        foreach ($employees->skip(2)->take(2) as $index => $employee) {
            $clockIn = Carbon::yesterday()->addHours(9)->addMinutes($index * 30); // Late arrivals

            $attendanceId = 'ATT-' . Carbon::yesterday()->format('Ymd') . '-' . str_pad($index + 4, 3, '0', STR_PAD_LEFT);

            Attendance::create([
                'employee_id' => $employee->employee_id,
                'attendance_id' => $attendanceId,
                'clock_in' => $clockIn,
                'clock_out' => null // Not checked out yet
            ]);

            // Create attendance history for clock in
            AttendanceHistory::create([
                'employee_id' => $employee->employee_id,
                'attendance_id' => $attendanceId,
                'date_attendance' => $clockIn,
                'attendance_type' => AttendanceHistory::TYPE_CLOCK_IN,
                'description' => 'Employee checked in'
            ]);
        }
    }
}
