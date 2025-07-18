@extends('layouts.dashboard')

@section('title', 'Department Management')



@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Department Management</h3>
                <div class="card-actions">
                    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#departmentModal" onclick="openCreateModal()">
                        <i class="ti ti-plus icon"></i>
                        Add Department
                    </button>
                </div>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table id="departmentsTable" class="table table-vcenter card-table">
                        <thead>
                            <tr>
                                <th>Department Name</th>
                                <th>Max Clock In</th>
                                <th>Max Clock Out</th>
                                <th>Employees</th>
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

<!-- Department Modal -->
<div class="modal fade" id="departmentModal" tabindex="-1" aria-labelledby="departmentModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="departmentModalLabel">Add Department</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="departmentForm">
                <div class="modal-body">
                    <input type="hidden" id="departmentId" name="id">
                    <div class="mb-3">
                        <label class="form-label">Department Name</label>
                        <input type="text" class="form-control" id="department_name" name="department_name" required>
                        <div class="invalid-feedback"></div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Max Clock In Time</label>
                                <input type="time" class="form-control" id="max_clock_in_time" name="max_clock_in_time" required>
                                <div class="invalid-feedback"></div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Max Clock Out Time</label>
                                <input type="time" class="form-control" id="max_clock_out_time" name="max_clock_out_time" required>
                                <div class="invalid-feedback"></div>
                            </div>
                        </div>
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
    const table = $('#departmentsTable').DataTable({
        processing: true,
        serverSide: true,
        ajax: {
            url: '{{ route("departments.index") }}',
            type: 'GET'
        },
        columns: [
            { data: 'department_name', name: 'department_name' },
            { data: 'max_clock_in_time', name: 'max_clock_in_time' },
            { data: 'max_clock_out_time', name: 'max_clock_out_time' },
            { data: 'employees_count', name: 'employees_count', searchable: false },
            {
                data: 'action',
                name: 'action',
                orderable: false,
                searchable: false
            }
        ]
    });

    // Form submission
    $('#departmentForm').on('submit', function(e) {
        e.preventDefault();

        const formData = new FormData(this);
        const departmentId = $('#departmentId').val();
        const url = departmentId ? `/departments/${departmentId}` : '/departments';
        const method = departmentId ? 'PUT' : 'POST';

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
            $('#departmentModal').modal('hide');
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
    $('#departmentModalLabel').text('Add Department');
    resetForm();
}

function editDepartment(id) {
    $('#departmentModalLabel').text('Edit Department');

    axios.get(`/departments/${id}/edit`)
        .then(function(response) {
            const department = response.data.data;
            $('#departmentId').val(department.id);
            $('#department_name').val(department.department_name);
            $('#max_clock_in_time').val(department.max_clock_in_time);
            $('#max_clock_out_time').val(department.max_clock_out_time);

            $('#departmentModal').modal('show');
        })
        .catch(function(error) {
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: 'Failed to load department data!'
            });
        });
}

function deleteDepartment(id) {
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
            axios.delete(`/departments/${id}`)
                .then(function(response) {
                    $('#departmentsTable').DataTable().ajax.reload();

                    Swal.fire({
                        icon: 'success',
                        title: 'Deleted!',
                        text: response.data.message,
                        timer: 3000
                    });
                })
                .catch(function(error) {
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
                            text: 'Failed to delete department!'
                        });
                    }
                });
        }
    });
}

function resetForm() {
    $('#departmentForm')[0].reset();
    $('#departmentId').val('');
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
