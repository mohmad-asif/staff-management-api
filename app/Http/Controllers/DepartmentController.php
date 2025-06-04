<?php

namespace App\Http\Controllers;

use App\Models\Department;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Exception;

class DepartmentController extends Controller
{
    public function index(Request $request)
    {
        $perPage = $request->get('per_page', 10);
        $sortBy = $request->get('sort_by', 'title');
        $sortOrder = $request->get('sort_order', 'asc');
        $search = $request->get('search', null);

        $allowedSorts = ['title', 'department_code', 'created_at'];
        if (!in_array($sortBy, $allowedSorts)) {
            $sortBy = 'title';
        }
        $sortOrder = strtolower($sortOrder) === 'asc' ? 'asc' : 'desc';

        $query = Department::query();

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('title', 'LIKE', "%{$search}%")
                    ->orWhere('department_code', 'LIKE', "%{$search}%");
            });
        }

        $departments = $query->orderBy($sortBy, $sortOrder)->paginate($perPage);

        $departments->getCollection()->transform(function ($item) {
            return [
                'id' => $item->id,
                'title' => $item->title,
                'department_code' => $item->department_code,
                'created_at' => $item->created_at->format('d-m-Y H:i'),
                'updated_at' => $item->updated_at->format('d-m-Y H:i'),
            ];
        });

        return $departments;
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string',
            'department_code' => 'required|string|unique:departments',
        ]);

        try {
            $department = DB::transaction(function () use ($validated) {
                return Department::create($validated);
            });

            return response()->json($department, 201);
        } catch (Exception $e) {
            return response()->json([
                'message' => 'Failed to create department.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    public function update(Request $request, Department $department)
    {
        $validated = $request->validate([
            'title' => 'sometimes|string',
            'department_code' => 'sometimes|string|unique:departments,department_code,' . $department->id,
        ]);

        try {
            DB::transaction(function () use ($department, $validated) {
                $department->update($validated);
            });

            return response()->json($department);
        } catch (Exception $e) {
            return response()->json([
                'message' => 'Failed to update department.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    public function destroy(Department $department)
    {
        try {
            DB::transaction(function () use ($department) {
                $department->delete();
            });

            return response()->json(['message' => 'Department deleted']);
        } catch (Exception $e) {
            return response()->json([
                'message' => 'Failed to delete department.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }
}
