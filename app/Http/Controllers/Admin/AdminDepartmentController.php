<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Department;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class AdminDepartmentController extends Controller
{
    public function index(Request $request): View
    {
        $departments = Department::withCount(['students', 'courses', 'lecturers'])
            ->when($request->filled('search'), function ($q) use ($request) {
                $term = '%'.$request->search.'%';
                $q->where(function ($query) use ($term) {
                    $query->where('name', 'like', $term)
                        ->orWhere('code', 'like', $term)
                        ->orWhere('building', 'like', $term);
                });
            })
            ->orderBy('name')
            ->get();

        return view('admin.departments.index', compact('departments'));
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'code' => ['required', 'string', 'max:10', 'unique:departments,code'],
            'building' => ['nullable', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
        ]);

        Department::create($validated);

        return redirect()->route('admin.departments.index')->with('success', 'Department created successfully.');
    }

    public function update(Request $request, Department $department): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'code' => ['required', 'string', 'max:10', 'unique:departments,code,'.$department->id],
            'building' => ['nullable', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
        ]);

        $department->update($validated);

        return redirect()->route('admin.departments.index')->with('success', 'Department updated successfully.');
    }

    public function destroy(Department $department): RedirectResponse
    {
        if ($department->courses()->exists() || $department->students()->exists()) {
            return back()->with('error', 'Cannot delete department with active students or courses attached.');
        }

        $department->delete();

        return redirect()->route('admin.departments.index')->with('success', 'Department deleted successfully.');
    }
}
