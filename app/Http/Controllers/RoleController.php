<?php

namespace App\Http\Controllers;

use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class RoleController extends Controller
{
    public function index(Request $request)
    {
        $roles = Role::query()
            ->when($request->get('q'), function ($query, $term) {
                $query->where('name', 'like', "%{$term}%");
            })
            ->latest()
            ->paginate(10)
            ->withQueryString();


        return view('roles.index', [
            'roles'  => $roles,
            'search' => $request->get('q', ''),
        ]);
    }

    public function create()
    {
        return view('roles.create', ['roleRecord' => new Role()]);
    }

    public function store(Request $request)
    {
        $validated = $this->validateData($request);

        Role::create($validated);

        return redirect()->route('roles.index')->with('success', 'Role added successfully.');
    }

    public function edit(Role $role)
    {
        return view('roles.create', ['roleRecord' => $role]);
    }

    public function update(Request $request, Role $role)
    {
        $validated = $this->validateData($request, $role->id);

        $role->update($validated);

        return redirect()->route('roles.index')->with('success', 'Role updated successfully.');
    }
    public function destroy(Role $role)
    {
        $role->delete();

        return redirect()->route('roles.index')->with('success', 'Role deleted successfully.');
    }

    private function validateData(Request $request, $ignoreId = null): array
    {
        return $request->validate([
            'name'   => ['required', 'string', 'max:255', Rule::unique('roles', 'name')->ignore($ignoreId)],
            'status' => ['required', Rule::in(['Active', 'Inactive'])],
        ]);
    }
}
