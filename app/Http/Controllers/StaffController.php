<?php

namespace App\Http\Controllers;

use App\Models\Department;
use App\Models\Staff;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Exception;

class StaffController extends Controller
{
    public function index(Request $request)
    {
        $query = Staff::query();

        // Search by name, email, or phone
        if ($search = $request->input('search')) {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%")
                    ->orWhere('phone', 'like', "%{$search}%");
            });
        }

        $sortable = ['name', 'email', 'phone'];
        $sortBy = in_array($request->input('sort_by'), $sortable) ? $request->input('sort_by') : 'name';
        $order = $request->input('order') === 'desc' ? 'desc' : 'asc';
        $query->orderBy($sortBy, $order);

        // Pagination
        $perPage = $request->input('per_page', 10);
        return $query->with(['departments:id,title', 'availabilities'])->paginate($perPage);
    }

    public function departments()
    {
        return Department::select('id', 'title')->get();
    }

    public function show(Staff $staff)
    {
        return $staff->load(['departments', 'availabilities']);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:staff,email',
            'phone' => 'nullable|string|max:20',
            'designation' => 'nullable|string|max:255',
            'joining_date' => 'nullable|date|before_or_equal:today',
            'status' => 'boolean',
            'department_ids' => 'array',
            'department_ids.*' => 'exists:departments,id',
            'availabilities' => 'array',
            'availabilities.*.day' => 'required|string',
            'availabilities.*.from' => 'required|date_format:H:i',
            'availabilities.*.to' => 'required|date_format:H:i|after:availabilities.*.from',
        ]);

        try {
            $staff = DB::transaction(function () use ($request, $validated) {
                $staff = Staff::create($validated);

                if ($request->has('department_ids')) {
                    $staff->departments()->attach($request->department_ids);
                }

                if ($request->has('availabilities')) {
                    foreach ($request->availabilities as $availability) {
                        $staff->availabilities()->create($availability);
                    }
                }

                return $staff;
            });

            return response()->json($staff->load(['departments', 'availabilities']), 201);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Failed to create staff record.',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function update(Request $request, Staff $staff)
    {
        $validated = $request->validate([
            'name' => 'sometimes|string|max:255',
            'email' => 'sometimes|email|unique:staff,email,' . $staff->id,
            'phone' => 'nullable|string|max:20',
            'designation' => 'nullable|string|max:255',
            'joining_date' => 'nullable|date|before_or_equal:today',
            'status' => 'boolean',
            'department_ids' => 'array',
            'department_ids.*' => 'exists:departments,id',
            'availabilities' => 'array',
            'availabilities.*.day' => 'required|string',
            'availabilities.*.from' => 'required|date_format:H:i',
            'availabilities.*.to' => 'required|date_format:H:i|after:availabilities.*.from',
        ]);

        $validated['updated_by'] = auth()->id();

        try {
            DB::transaction(function () use ($staff, $request, $validated) {
                $staff->update($validated);

                if ($request->has('department_ids')) {
                    $staff->departments()->sync($request->department_ids);
                }

                if ($request->has('availabilities')) {
                    $staff->availabilities()->delete();
                    foreach ($request->availabilities as $availability) {
                        $staff->availabilities()->create($availability);
                    }
                }
            });

            return response()->json($staff->load(['departments', 'availabilities']));
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Failed to update staff record.',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function destroy(Staff $staff)
    {
        try {
            DB::transaction(function () use ($staff) {
                $staff->delete();
            });

            return response()->json(['message' => 'Staff deleted']);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Failed to delete staff.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    // public function restore($id)
    // {
    //     $staff = Staff::onlyTrashed()->findOrFail($id);
    //     $staff->restore();
    //     return response()->json(['message' => 'Staff restored']);
    // }

    // public function forceDelete($id)
    // {
    //     $staff = Staff::onlyTrashed()->findOrFail($id);
    //     $staff->forceDelete();
    //     return response()->json(['message' => 'Staff permanently deleted']);
    // }
}
