@extends('layouts.dashboard')

@section('title', 'Dashboard')

@section('content')
<div class="row row-deck row-cards">
    <div class="col-sm-6 col-lg-3">
        <div class="card">
            <div class="card-body">
                <div class="d-flex align-items-center">
                    <div class="subheader">Total Employees</div>
                </div>
                <div class="h1 mb-3">{{ $totalEmployees }}</div>
                <div class="d-flex mb-2">
                    <div class="flex-fill">
                        <div class="progress progress-sm">
                            <div class="progress-bar bg-primary" style="width: 100%" role="progressbar"></div>
                        </div>
                    </div>
                </div>
                <div class="text-muted">Registered employees</div>
            </div>
        </div>
    </div>
    <div class="col-sm-6 col-lg-3">
        <div class="card">
            <div class="card-body">
                <div class="d-flex align-items-center">
                    <div class="subheader">Departments</div>
                </div>
                <div class="h1 mb-3">{{ $totalDepartments }}</div>
                <div class="d-flex mb-2">
                    <div class="flex-fill">
                        <div class="progress progress-sm">
                            <div class="progress-bar bg-success" style="width: 100%" role="progressbar"></div>
                        </div>
                    </div>
                </div>
                <div class="text-muted">Active departments</div>
            </div>
        </div>
    </div>
    <div class="col-sm-6 col-lg-3">
        <div class="card">
            <div class="card-body">
                <div class="d-flex align-items-center">
                    <div class="subheader">Today's Check-ins</div>
                </div>
                <div class="h1 mb-3">{{ $todayAttendances }}</div>
                <div class="d-flex mb-2">
                    <div class="flex-fill">
                        <div class="progress progress-sm">
                            <div class="progress-bar bg-info" style="width: {{ $totalEmployees > 0 ? ($todayAttendances / $totalEmployees) * 100 : 0 }}%" role="progressbar"></div>
                        </div>
                    </div>
                    <div class="ms-3">
                        <span class="text-green d-inline-flex align-items-center lh-1">
                            {{ $totalEmployees > 0 ? round(($todayAttendances / $totalEmployees) * 100) : 0 }}%
                        </span>
                    </div>
                </div>
                <div class="text-muted">Attendance rate today</div>
            </div>
        </div>
    </div>
    <div class="col-sm-6 col-lg-3">
        <div class="card">
            <div class="card-body">
                <div class="d-flex align-items-center">
                    <div class="subheader">Today's Check-outs</div>
                </div>
                <div class="h1 mb-3">{{ $todayCheckouts }}</div>
                <div class="d-flex mb-2">
                    <div class="flex-fill">
                        <div class="progress progress-sm">
                            <div class="progress-bar bg-warning" style="width: {{ $todayAttendances > 0 ? ($todayCheckouts / $todayAttendances) * 100 : 0 }}%" role="progressbar"></div>
                        </div>
                    </div>
                    <div class="ms-3">
                        <span class="text-yellow d-inline-flex align-items-center lh-1">
                            {{ $todayAttendances > 0 ? round(($todayCheckouts / $todayAttendances) * 100) : 0 }}%
                        </span>
                    </div>
                </div>
                <div class="text-muted">Checkout completion rate</div>
            </div>
        </div>
    </div>
</div>

<div class="row row-deck row-cards mt-4">
    <div class="col-md-6">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Department Statistics</h3>
            </div>
            <div class="card-body">
                @forelse($departmentStats as $dept)
                <div class="row align-items-center mb-3">
                    <div class="col">
                        <div class="font-weight-medium">{{ $dept->department_name }}</div>
                        <div class="text-muted">{{ $dept->employees_count }} employees</div>
                    </div>
                    <div class="col-auto">
                        <span class="badge bg-primary text-white">{{ $dept->today_attendance }} present</span>
                    </div>
                </div>
                @empty
                <div class="empty">
                    <div class="empty-icon">
                        <i class="ti ti-building"></i>
                    </div>
                    <p class="empty-title">No departments</p>
                    <p class="empty-subtitle text-muted">Create departments to see statistics</p>
                </div>
                @endforelse
            </div>
        </div>
    </div>

    <div class="col-md-6">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Recent Attendance</h3>
            </div>
            <div class="card-body">
                @forelse($recentAttendances as $attendance)
                <div class="row align-items-center mb-3">
                    <div class="col">
                        <div class="font-weight-medium">{{ $attendance->employee->name }}</div>
                        <div class="text-muted">{{ $attendance->employee->department->department_name }}</div>
                    </div>
                    <div class="col-auto">
                        <div class="text-end">
                            <div class="text-muted">{{ $attendance->clock_in->format('H:i') }}</div>
                            @if($attendance->status == 'On Time')
                                <span class="badge bg-success text-white">On Time</span>
                            @elseif($attendance->status == 'Late')
                                <span class="badge bg-danger text-white">Late</span>
                            @else
                                <span class="badge bg-warning text-white">{{ $attendance->status }}</span>
                            @endif
                        </div>
                    </div>
                </div>
                @empty
                <div class="empty">
                    <div class="empty-icon">
                        <i class="ti ti-clock"></i>
                    </div>
                    <p class="empty-title">No attendance records</p>
                    <p class="empty-subtitle text-muted">Attendance logs will appear here</p>
                </div>
                @endforelse
            </div>
        </div>
    </div>
</div>
@endsection