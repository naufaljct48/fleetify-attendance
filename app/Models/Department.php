<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Department extends Model
{
    protected $table = 'departments';

    protected $fillable = [
        'department_name',
        'max_clock_in_time',
        'max_clock_out_time'
    ];

    protected $casts = [
        'max_clock_in_time' => 'datetime:H:i',
        'max_clock_out_time' => 'datetime:H:i'
    ];

    /**
     * Get all employees for this department
     */
    public function employees(): HasMany
    {
        return $this->hasMany(Employee::class, 'department_id');
    }
}
