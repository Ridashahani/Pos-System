<?php

namespace App\Http\Controllers;

use App\Models\Branch;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    /**
     * Users/Roles listing page.
     */
    public function index(Request $request)
    {
        $users = User::with(['role', 'branch'])
            ->when($request->get('q'), function ($query, $term) {
                $query->where('name', 'like', "%{$term}%")
                    ->orWhere('email', 'like', "%{$term}%");
            })
            ->latest()
            ->paginate(10)
            ->withQueryString();

            return view('users.index', [
        'users'  => $users,
        'search' => $request->get('q', ''),
    ]);
    }

    /**
     * "Add User" form.
     */
    public function create()
    {
        return view('users.create', [
            'userRecord' => new User(),
            'roles'      => Role::where('status', 'Active')->orderBy('name')->get(),
            'branches'   => Branch::orderBy('name')->get(), // SoftDeletes ki wajah se trashed khud hi exclude hongi
        ]);
    }

    public function store(Request $request)
    {
        $validated = $this->validateData($request);

        $validated['password'] = Hash::make(Str::random(12));

        User::create($validated);

        return redirect()
            ->route('users.index')
            ->with('success', 'User added successfully.');
    }

    public function show(User $user)
    {
        return view('users.show', compact('user'));
    }

    public function edit(User $user)
    {
        return view('users.create', [
            'userRecord' => $user,
            'roles'      => Role::where('status', 'Active')->orderBy('name')->get(),
            'branches'   => Branch::orderBy('name')->get(),
        ]);
    }

    public function update(Request $request, User $user)
    {
        $validated = $this->validateData($request, $user->id);

        $user->update($validated);

        return redirect()
            ->route('users.index')
            ->with('success', 'User updated successfully.');
    }

    public function destroy(User $user)
    {
        $user->delete();

        return redirect()
            ->route('users.index')
            ->with('success', 'User deleted successfully.');
    }

    private function validateData(Request $request, $ignoreId = null): array
    {
        return $request->validate([
            'name'      => ['required', 'string', 'max:255'],
            'email'     => [
                'required',
                'email',
                'max:255',
                Rule::unique('users', 'email')->ignore($ignoreId),
            ],
            'role_id'   => ['required', 'exists:roles,id'],
            'branch_id' => ['required', 'exists:branches,id'],
            'status'    => ['required', Rule::in(['Active', 'Inactive'])],
        ]);
    }
}
