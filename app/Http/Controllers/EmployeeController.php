<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use App\Models\Department;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Yajra\DataTables\DataTables;

class EmployeeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $employees = Employee::with('department');

            return DataTables::of($employees)
                ->addColumn('action', function($employee) {
                    return '
                        <button type="button" class="btn btn-sm btn-outline-primary" onclick="editEmployee('.$employee->id.')">
                            <i class="ti ti-edit icon"></i> Edit
                        </button>
                        <button type="button" class="btn btn-sm btn-outline-danger" onclick="deleteEmployee('.$employee->id.')">
                            <i class="ti ti-trash icon"></i> Delete
                        </button>
                    ';
                })
                ->rawColumns(['action'])
                ->make(true);
        }

        $departments = Department::all();
        return view('employees.index', compact('departments'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): JsonResponse
    {
        $request->validate([
            'employee_id' => 'required|string|max:50|unique:employee,employee_id',
            'department_id' => 'required|exists:departments,id',
            'name' => 'required|string|max:255',
            'address' => 'required|string'
        ]);

        $employee = Employee::create($request->all());
        $employee->load('department');

        return response()->json([
            'success' => true,
            'message' => 'Employee created successfully!',
            'data' => $employee
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Employee $employee): JsonResponse
    {
        $employee->load('department');

        return response()->json([
            'success' => true,
            'data' => $employee
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Employee $employee): JsonResponse
    {
        $request->validate([
            'employee_id' => 'required|string|max:50|unique:employee,employee_id,' . $employee->id,
            'department_id' => 'required|exists:departments,id',
            'name' => 'required|string|max:255',
            'address' => 'required|string'
        ]);

        $employee->update($request->all());
        $employee->load('department');

        return response()->json([
            'success' => true,
            'message' => 'Employee updated successfully!',
            'data' => $employee
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Employee $employee): JsonResponse
    {
        $employee->delete();

        return response()->json([
            'success' => true,
            'message' => 'Employee deleted successfully!'
        ]);
    }
}
