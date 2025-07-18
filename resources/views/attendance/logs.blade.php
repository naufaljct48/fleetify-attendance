@extends('layouts.dashboard')

@section('title', 'Attendance Logs')



@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Attendance Logs</h3>
                <div class="card-actions">
                    <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#checkinModal">
                        <i class="ti ti-clock icon"></i>
                        Check In
                    </button>
                    <button type="button" class="btn btn-warning text-white" data-bs-toggle="modal" data-bs-target="#checkoutModal">
                        <i class="ti ti-clock-off icon"></i>
                        Check Out
                    </button>
                </div>
            </div>
            <div class="card-body">
                <!-- Filters -->
                <div class="row mb-3">
                    <div class="col-md-4">
                        <label class="form-label">Filter by Date</label>
                        <input type="date" class="form-control" id="dateFilter" value="{{ date('Y-m-d') }}">
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Filter by Department</label>
                        <select class="form-select" id="departmentFilter">
                            <option value="">All Departments</option>
                            @foreach($departments as $department)
                                <option value="{{ $department->id }}">{{ $department->department_name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">&nbsp;</label>
                        <div>
                            <button type="button" class="btn btn-primary" onclick="filterTable()">
                                <i class="ti ti-filter icon"></i>
                                Apply Filter
                            </button>
                        </div>
                    </div>
                </div>

                <div class="table-responsive">
                    <table id="attendanceTable" class="table table-vcenter card-table">
                        <thead>
                            <tr>
                                <th>Employee</th>
                                <th>Department</th>
                                <th>Clock In</th>
                                <th>Clock Out</th>
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <!-- DataTables will populate this -->
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Check In Modal -->
<div class="modal fade" id="checkinModal" tabindex="-1" aria-labelledby="checkinModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="checkinModalLabel">Check In</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="checkinForm">
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Select Employee</label>
                        <select class="form-select" id="checkin_employee_id" name="employee_id" required>
                            <option value="">Choose Employee</option>
                            @foreach($employees as $employee)
                                <option value="{{ $employee->employee_id }}">{{ $employee->name }} ({{ $employee->employee_id }})</option>
                            @endforeach
                        </select>
                        <div class="invalid-feedback"></div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-success">Check In</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Check Out Modal -->
<div class="modal fade" id="checkoutModal" tabindex="-1" aria-labelledby="checkoutModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="checkoutModalLabel">Check Out</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="checkoutForm">
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Select Employee</label>
                        <select class="form-select" id="checkout_employee_id" name="employee_id" required>
                            <option value="">Choose Employee</option>
                            @foreach($employees as $employee)
                                <option value="{{ $employee->employee_id }}">{{ $employee->name }} ({{ $employee->employee_id }})</option>
                            @endforeach
                        </select>
                        <div class="invalid-feedback"></div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-warning text-white">Check Out</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Detail Modal -->
<div class="modal fade" id="detailModal" tabindex="-1" aria-labelledby="detailModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="detailModalLabel">Attendance Detail</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body" id="detailContent">
                <!-- Detail content will be loaded here -->
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
let table;

$(document).ready(function() {
    // Initialize DataTable
    table = $('#attendanceTable').DataTable({
        processing: true,
        serverSide: true,
        ajax: {
            url: '{{ route("attendance.logs") }}',
            type: 'GET',
            data: function(d) {
                d.date = $('#dateFilter').val();
                d.department = $('#departmentFilter').val();
            }
        },
        columns: [
            { data: 'employee.name', name: 'employee.name' },
            { data: 'employee.department.department_name', name: 'employee.department.department_name' },
            { data: 'clock_in', name: 'clock_in' },
            { data: 'clock_out', name: 'clock_out' },
            { data: 'status', name: 'status', orderable: false },
            {
                data: 'action',
                name: 'action',
                orderable: false,
                searchable: false
            }
        ]
    });

    // Check In Form
    $('#checkinForm').on('submit', function(e) {
        e.preventDefault();

        const formData = new FormData(this);

        axios.post('/attendance/checkin', formData, {
            headers: {
                'Content-Type': 'multipart/form-data',
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        }).then(function(response) {
            $('#checkinModal').modal('hide');
            table.ajax.reload();

            Swal.fire({
                icon: 'success',
                title: 'Success',
                text: response.data.message,
                timer: 3000
            });

            $('#checkinForm')[0].reset();
        }).catch(function(error) {
            if (error.response && error.response.data.message) {
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: error.response.data.message
                });
            } else {
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'Something went wrong!'
                });
            }
        });
    });

    // Check Out Form
    $('#checkoutForm').on('submit', function(e) {
        e.preventDefault();

        const formData = new FormData(this);

        // Use axios.put for proper PUT request
        const data = {
            employee_id: formData.get('employee_id'),
            _token: $('meta[name="csrf-token"]').attr('content')
        };

        axios.put('/attendance/checkout', data, {
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        }).then(function(response) {
            $('#checkoutModal').modal('hide');
            table.ajax.reload();

            Swal.fire({
                icon: 'success',
                title: 'Success',
                text: response.data.message,
                timer: 3000
            });

            $('#checkoutForm')[0].reset();
        }).catch(function(error) {
            if (error.response && error.response.data.message) {
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: error.response.data.message
                });
            } else {
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'Something went wrong!'
                });
            }
        });
    });
});

function filterTable() {
    table.ajax.reload();
}

function viewDetail(id) {
    axios.get(`/attendance/${id}/detail`)
        .then(function(response) {
            $('#detailContent').html(response.data.html);
            $('#detailModal').modal('show');
        })
        .catch(function(error) {
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: 'Failed to load attendance detail!'
            });
        });
}
</script>
@endpush
