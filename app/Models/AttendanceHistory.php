<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AttendanceHistory extends Model
{
    protected $table = 'attendance_history';

    protected $fillable = [
        'employee_id',
        'attendance_id',
        'date_attendance',
        'attendance_type',
        'description'
    ];

    protected $casts = [
        'date_attendance' => 'datetime'
    ];

    // Constants for attendance types
    public const TYPE_CLOCK_IN = 1;
    public const TYPE_CLOCK_OUT = 2;

    /**
     * Get the employee that owns the attendance history
     */
    public function employee(): BelongsTo
    {
        return $this->belongsTo(Employee::class, 'employee_id', 'employee_id');
    }

    /**
     * Get the attendance that owns the attendance history
     */
    public function attendance(): BelongsTo
    {
        return $this->belongsTo(Attendance::class, 'attendance_id', 'attendance_id');
    }

    /**
     * Get attendance type label
     */
    public function getTypeLabel(): string
    {
        return match($this->attendance_type) {
            self::TYPE_CLOCK_IN => 'Clock In',
            self::TYPE_CLOCK_OUT => 'Clock Out',
            default => 'Unknown'
        };
    }
}
