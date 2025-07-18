<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Carbon\Carbon;

class Attendance extends Model
{
    protected $table = 'attendance';

    protected $fillable = [
        'employee_id',
        'attendance_id',
        'clock_in',
        'clock_out'
    ];

    protected $casts = [
        'clock_in' => 'datetime',
        'clock_out' => 'datetime'
    ];

    /**
     * Get the employee that owns the attendance
     */
    public function employee(): BelongsTo
    {
        return $this->belongsTo(Employee::class, 'employee_id', 'employee_id');
    }

    /**
     * Get all attendance history for this attendance
     */
    public function attendanceHistory(): HasMany
    {
        return $this->hasMany(AttendanceHistory::class, 'attendance_id', 'attendance_id');
    }

    /**
     * Get attendance status based on department rules
     */
    public function getStatusAttribute(): string
    {
        if (!$this->employee || !$this->employee->department) {
            return 'Unknown';
        }

        $department = $this->employee->department;
        $clockIn = Carbon::parse($this->clock_in);
        $maxClockIn = Carbon::parse($department->max_clock_in_time);

        // Check if late for clock in
        if ($clockIn->format('H:i') > $maxClockIn->format('H:i')) {
            return 'Late';
        }

        // Check if early leave (if clock_out exists)
        if ($this->clock_out) {
            $clockOut = Carbon::parse($this->clock_out);
            $maxClockOut = Carbon::parse($department->max_clock_out_time);

            if ($clockOut->format('H:i') < $maxClockOut->format('H:i')) {
                return 'Early Leave';
            }
        }

        return 'On Time';
    }
}
