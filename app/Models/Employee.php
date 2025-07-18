<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Employee extends Model
{
    protected $table = 'employee';

    protected $fillable = [
        'employee_id',
        'department_id',
        'name',
        'address'
    ];

    /**
     * Get the department that owns the employee
     */
    public function department(): BelongsTo
    {
        return $this->belongsTo(Department::class, 'department_id');
    }

    /**
     * Get all attendance records for this employee
     */
    public function attendances(): HasMany
    {
        return $this->hasMany(Attendance::class, 'employee_id', 'employee_id');
    }

    /**
     * Get all attendance history for this employee
     */
    public function attendanceHistory(): HasMany
    {
        return $this->hasMany(AttendanceHistory::class, 'employee_id', 'employee_id');
    }
}
