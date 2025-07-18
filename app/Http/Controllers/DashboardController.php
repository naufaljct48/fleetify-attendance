<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Employee;
use App\Models\Department;
use App\Models\Attendance;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function index(): View
    {
        // Get statistics for dashboard
        $totalEmployees = Employee::count();
        $totalDepartments = Department::count();

        // Today's attendance statistics
        $todayAttendances = Attendance::whereDate('clock_in', Carbon::today())->count();
        $todayCheckouts = Attendance::whereDate('clock_in', Carbon::today())
            ->whereNotNull('clock_out')
            ->count();

        // Recent attendance logs
        $recentAttendances = Attendance::with(['employee.department'])
            ->orderBy('clock_in', 'desc')
            ->limit(10)
            ->get();

        // Department statistics
        $departmentStats = Department::withCount(['employees'])
            ->get()
            ->map(function($dept) {
                $todayAttendance = Attendance::whereDate('clock_in', Carbon::today())
                    ->whereHas('employee', function($q) use ($dept) {
                        $q->where('department_id', $dept->id);
                    })
                    ->count();

                $dept->today_attendance = $todayAttendance;
                return $dept;
            });

        return view('dashboard', compact(
            'totalEmployees',
            'totalDepartments',
            'todayAttendances',
            'todayCheckouts',
            'recentAttendances',
            'departmentStats'
        ));
    }
}
