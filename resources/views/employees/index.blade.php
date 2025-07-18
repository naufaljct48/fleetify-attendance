@extends('layouts.dashboard')

@section('title', 'Employee Management')



@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Employee Management</h3>
                <div class="card-actions">
                    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#employeeModal" onclick="openCreateModal()">
                        <i class="ti ti-plus icon"></i>
                        Add Employee
                    </button>
                </div>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table id="employeesTable" class="table table-vcenter card-table">
                        <thead>
                            <tr>
                                <th>Employee ID</th>
                                <th>Name</th>
                                <th>Department</th>
                                <th>Address</th>
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

<!-- Employee Modal -->
<div class="modal fade" id="employeeModal" tabindex="-1" aria-labelledby="employeeModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="employeeModalLabel">Add Employee</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="employeeForm">
                <div class="modal-body">
                    <input type="hidden" id="employeeId" name="id">
                    <div class="mb-3">
                        <label class="form-label">Employee ID</label>
                        <input type="text" class="form-control" id="employee_id" name="employee_id" required>
                        <div class="invalid-feedback"></div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Department</label>
                        <select class="form-select" id="department_id" name="department_id" required>
                            <option value="">Select Department</option>
                            @foreach($departments as $department)
                                <option value="{{ $department->id }}">{{ $department->department_name }}</option>
                            @endforeach
                        </select>
                        <div class="invalid-feedback"></div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Name</label>
                        <input type="text" class="form-control" id="name" name="name" required>
                        <div class="invalid-feedback"></div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Address</label>
                        <textarea class="form-control" id="address" name="address" rows="3" required></textarea>
                        <div class="invalid-feedback"></div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Save</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
$(document).ready(function() {
    // Initialize DataTable
    const table = $('#employeesTable').DataTable({
        processing: true,
        serverSide: true,
        ajax: {
            url: '{{ route("employees.index") }}',
            type: 'GET'
        },
        columns: [
            { data: 'employee_id', name: 'employee_id' },
            { data: 'name', name: 'name' },
            { data: 'department.department_name', name: 'department.department_name' },
            { data: 'address', name: 'address' },
            {
                data: 'action',
                name: 'action',
                orderable: false,
                searchable: false
            }
        ]
    });

    // Form submission
    $('#employeeForm').on('submit', function(e) {
        e.preventDefault();

        const formData = new FormData(this);
        const employeeId = $('#employeeId').val();
        const url = employeeId ? `/employees/${employeeId}` : '/employees';
        const method = employeeId ? 'PUT' : 'POST';

        // Convert FormData to regular object for JSON
        const data = {};
        for (let [key, value] of formData.entries()) {
            data[key] = value;
        }
        data._token = $('meta[name="csrf-token"]').attr('content');

        axios({
            method: method,
            url: url,
            data: data,
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        }).then(function(response) {
            $('#employeeModal').modal('hide');
            table.ajax.reload();

            Swal.fire({
                icon: 'success',
                title: 'Success',
                text: response.data.message,
                timer: 3000
            });

            resetForm();
        }).catch(function(error) {
            if (error.response && error.response.data.errors) {
                displayValidationErrors(error.response.data.errors);
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

function openCreateModal() {
    $('#employeeModalLabel').text('Add Employee');
    resetForm();
}

function editEmployee(id) {
    $('#employeeModalLabel').text('Edit Employee');

    axios.get(`/employees/${id}/edit`)
        .then(function(response) {
            const employee = response.data.data;
            $('#employeeId').val(employee.id);
            $('#employee_id').val(employee.employee_id);
            $('#department_id').val(employee.department_id);
            $('#name').val(employee.name);
            $('#address').val(employee.address);

            $('#employeeModal').modal('show');
        })
        .catch(function(error) {
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: 'Failed to load employee data!'
            });
        });
}

function deleteEmployee(id) {
    Swal.fire({
        title: 'Are you sure?',
        text: "You won't be able to revert this!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#3085d6',
        confirmButtonText: 'Yes, delete it!'
    }).then((result) => {
        if (result.isConfirmed) {
            axios.delete(`/employees/${id}`)
                .then(function(response) {
                    $('#employeesTable').DataTable().ajax.reload();

                    Swal.fire({
                        icon: 'success',
                        title: 'Deleted!',
                        text: response.data.message,
                        timer: 3000
                    });
                })
                .catch(function(error) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: 'Failed to delete employee!'
                    });
                });
        }
    });
}

function resetForm() {
    $('#employeeForm')[0].reset();
    $('#employeeId').val('');
    $('.form-control').removeClass('is-invalid');
    $('.invalid-feedback').text('');
}

function displayValidationErrors(errors) {
    $('.form-control').removeClass('is-invalid');
    $('.invalid-feedback').text('');

    $.each(errors, function(field, messages) {
        $(`#${field}`).addClass('is-invalid');
        $(`#${field}`).siblings('.invalid-feedback').text(messages[0]);
    });
}
</script>
@endpush
