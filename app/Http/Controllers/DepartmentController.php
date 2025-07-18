<?php

namespace App\Http\Controllers;

use App\Models\Department;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Yajra\DataTables\DataTables;

class DepartmentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $departments = Department::withCount('employees');

            return DataTables::of($departments)
                ->addColumn('employees_count', function($department) {
                    return '<span class="badge bg-primary text-white">' . $department->employees_count . ' employees</span>';
                })
                ->addColumn('action', function($department) {
                    return '
                        <button type="button" class="btn btn-sm btn-outline-primary" onclick="editDepartment('.$department->id.')">
                            <i class="ti ti-edit icon"></i> Edit
                        </button>
                        <button type="button" class="btn btn-sm btn-outline-danger" onclick="deleteDepartment('.$department->id.')">
                            <i class="ti ti-trash icon"></i> Delete
                        </button>
                    ';
                })
                ->rawColumns(['employees_count', 'action'])
                ->make(true);
        }

        return view('departments.index');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): JsonResponse
    {
        $request->validate([
            'department_name' => 'required|string|max:255',
            'max_clock_in_time' => 'required|date_format:H:i',
            'max_clock_out_time' => 'required|date_format:H:i'
        ]);

        $department = Department::create($request->all());

        return response()->json([
            'success' => true,
            'message' => 'Department created successfully!',
            'data' => $department
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Department $department): JsonResponse
    {
        return response()->json([
            'success' => true,
            'data' => $department
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Department $department): JsonResponse
    {
        $request->validate([
            'department_name' => 'required|string|max:255',
            'max_clock_in_time' => 'required|date_format:H:i',
            'max_clock_out_time' => 'required|date_format:H:i'
        ]);

        $department->update($request->all());

        return response()->json([
            'success' => true,
            'message' => 'Department updated successfully!',
            'data' => $department
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Department $department): JsonResponse
    {
        // Check if department has employees
        if ($department->employees()->count() > 0) {
            return response()->json([
                'success' => false,
                'message' => 'Cannot delete department with existing employees'
            ], 422);
        }

        $department->delete();

        return response()->json([
            'success' => true,
            'message' => 'Department deleted successfully!'
        ]);
    }
}
