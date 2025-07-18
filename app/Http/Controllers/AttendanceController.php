<?php

namespace App\Http\Controllers;

use App\Models\Attendance;
use App\Models\AttendanceHistory;
use App\Models\Employee;
use App\Models\Department;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Yajra\DataTables\DataTables;
use Carbon\Carbon;
use Illuminate\Support\Str;

class AttendanceController extends Controller
{
    /**
     * Display attendance logs with filters
     */
    public function logs(Request $request)
    {
        $query = Attendance::with(['employee.department']);

        // Filter by date
        if ($request->filled('date')) {
            $query->whereDate('clock_in', $request->date);
        }

        // Filter by department
        if ($request->filled('department')) {
            $query->whereHas('employee', function($q) use ($request) {
                $q->where('department_id', $request->department);
            });
        }

        if ($request->ajax()) {
            return DataTables::of($query)
                ->addColumn('clock_in', function($attendance) {
                    return $attendance->clock_in ? $attendance->clock_in->format('H:i') : '-';
                })
                ->addColumn('clock_out', function($attendance) {
                    return $attendance->clock_out ? $attendance->clock_out->format('H:i') : '<span class="text-muted">Not checked out</span>';
                })
                ->addColumn('status', function($attendance) {
                    $status = $attendance->status;
                    $badgeClass = match($status) {
                        'On Time' => 'bg-success',
                        'Late' => 'bg-danger',
                        'Early Leave' => 'bg-warning',
                        default => 'bg-secondary'
                    };
                    return '<span class="badge ' . $badgeClass . ' text-white">' . $status . '</span>';
                })
                ->addColumn('action', function($attendance) {
                    return '
                        <button type="button" class="btn btn-sm btn-outline-primary" onclick="viewDetail('.$attendance->id.')">
                            <i class="ti ti-eye icon"></i> Detail
                        </button>
                    ';
                })
                ->rawColumns(['clock_out', 'status', 'action'])
                ->make(true);
        }

        $departments = Department::all();
        $employees = Employee::with('department')->get();

        return view('attendance.logs', compact('departments', 'employees'));
    }

    /**
     * Check-in attendance
     */
    public function checkin(Request $request): JsonResponse
    {
        $request->validate([
            'employee_id' => 'required|exists:employee,employee_id'
        ]);

        $employee = Employee::where('employee_id', $request->employee_id)->first();

        // Check if already checked in today
        $existingAttendance = Attendance::where('employee_id', $request->employee_id)
            ->whereDate('clock_in', Carbon::today())
            ->whereNull('clock_out')
            ->first();

        if ($existingAttendance) {
            return response()->json([
                'success' => false,
                'message' => 'Employee already checked in today'
            ], 422);
        }

        $attendanceId = 'ATT-' . Carbon::now()->format('Ymd') . '-' . Str::random(6);

        $attendance = Attendance::create([
            'employee_id' => $request->employee_id,
            'attendance_id' => $attendanceId,
            'clock_in' => Carbon::now()
        ]);

        // Create attendance history
        AttendanceHistory::create([
            'employee_id' => $request->employee_id,
            'attendance_id' => $attendanceId,
            'date_attendance' => Carbon::now(),
            'attendance_type' => AttendanceHistory::TYPE_CLOCK_IN,
            'description' => 'Employee checked in'
        ]);

        $attendance->load('employee.department');

        return response()->json([
            'success' => true,
            'message' => 'Check-in successful for ' . $employee->name . '!',
            'data' => $attendance
        ]);
    }

    /**
     * Check-out attendance
     */
    public function checkout(Request $request): JsonResponse
    {
        $request->validate([
            'employee_id' => 'required|exists:employee,employee_id'
        ]);

        $employee = Employee::where('employee_id', $request->employee_id)->first();

        // Find today's attendance without checkout
        $attendance = Attendance::where('employee_id', $request->employee_id)
            ->whereDate('clock_in', Carbon::today())
            ->whereNull('clock_out')
            ->first();

        if (!$attendance) {
            return response()->json([
                'success' => false,
                'message' => 'No check-in record found for today'
            ], 422);
        }

        $attendance->update([
            'clock_out' => Carbon::now()
        ]);

        // Create attendance history
        AttendanceHistory::create([
            'employee_id' => $request->employee_id,
            'attendance_id' => $attendance->attendance_id,
            'date_attendance' => Carbon::now(),
            'attendance_type' => AttendanceHistory::TYPE_CLOCK_OUT,
            'description' => 'Employee checked out'
        ]);

        $attendance->load('employee.department');

        return response()->json([
            'success' => true,
            'message' => 'Check-out successful for ' . $attendance->employee->name . '!',
            'data' => $attendance
        ]);
    }

    /**
     * Get attendance detail
     */
    public function detail(Attendance $attendance): JsonResponse
    {
        $attendance->load(['employee.department']);

        $html = view('attendance.detail', compact('attendance'))->render();

        return response()->json([
            'success' => true,
            'html' => $html
        ]);
    }
}
