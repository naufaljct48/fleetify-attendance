<div class="row">
    <div class="col-md-6">
        <div class="mb-3">
            <label class="form-label">Employee Name</label>
            <div class="form-control-plaintext">{{ $attendance->employee->name }}</div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="mb-3">
            <label class="form-label">Employee ID</label>
            <div class="form-control-plaintext">{{ $attendance->employee->employee_id }}</div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-6">
        <div class="mb-3">
            <label class="form-label">Department</label>
            <div class="form-control-plaintext">{{ $attendance->employee->department->department_name }}</div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="mb-3">
            <label class="form-label">Date</label>
            <div class="form-control-plaintext">{{ $attendance->clock_in->format('d M Y') }}</div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-6">
        <div class="mb-3">
            <label class="form-label">Clock In</label>
            <div class="form-control-plaintext">
                {{ $attendance->clock_in ? $attendance->clock_in->format('H:i') : '-' }}
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="mb-3">
            <label class="form-label">Clock Out</label>
            <div class="form-control-plaintext">
                {{ $attendance->clock_out ? $attendance->clock_out->format('H:i') : 'Not checked out yet' }}
            </div>
        </div>
    </div>
</div>

<div class="mb-3">
    <label class="form-label">Status</label>
    <div class="form-control-plaintext">
        @if($attendance->status == 'On Time')
            <span class="badge bg-success text-white">On Time</span>
        @elseif($attendance->status == 'Late')
            <span class="badge bg-danger text-white">Late</span>
        @elseif($attendance->status == 'Early Leave')
            <span class="badge bg-warning text-white">Early Leave</span>
        @else
            <span class="badge bg-secondary text-white">{{ $attendance->status }}</span>
        @endif
    </div>
</div>

<div class="row">
    <div class="col-md-6">
        <div class="mb-3">
            <label class="form-label">Max Clock In Time</label>
            <div class="form-control-plaintext">{{ $attendance->employee->department->max_clock_in_time }}</div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="mb-3">
            <label class="form-label">Max Clock Out Time</label>
            <div class="form-control-plaintext">{{ $attendance->employee->department->max_clock_out_time }}</div>
        </div>
    </div>
</div>
