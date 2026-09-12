@extends('layouts.app')

@section('content')
    <div class="p-6">

        <div class="flex items-center justify-between mb-6">
            <h1 class="text-lg font-semibold text-gray-800">Roles</h1>
            <a href="{{ route('users.index') }}" class="text-sm text-gray-500 hover:underline">← Back to Users</a>
        </div>

        @if (session('success'))
            <div class="mb-4 rounded-lg bg-green-50 border border-green-200 text-green-700 px-4 py-2 text-sm">
                {{ session('success') }}
            </div>
        @endif

        <div class="mb-1">
            <h2 class="text-2xl font-bold text-gray-900">Manage Roles</h2>
            <p class="text-gray-500 text-sm mt-1">Naya role yahan se add karein — koi migration ki zarurat nahi.</p>
        </div>

        <div class="flex items-center justify-between mt-6 mb-4">
            <form method="GET" action="{{ route('roles.index') }}">
                <input type="text" name="q" value="{{ $search }}" placeholder="Search roles..."
                    class="w-72 rounded-lg border border-gray-300 px-4 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-amber-400"
                    onchange="this.form.submit()">
            </form>

            <a href="{{ route('roles.create') }}"
                class="inline-flex items-center gap-2 rounded-lg bg-blue-500 hover:bg-blue-600 text-white font-medium px-4 py-2 text-sm shadow-sm">
                + Add Role
            </a>
        </div>

        <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
            <table class="min-w-full text-sm">
                <thead>
                    <tr class="text-left text-gray-500 border-b border-gray-100">
                        <th class="px-6 py-3 font-medium">Role Name</th>
                        <th class="px-6 py-3 font-medium">Status</th>
                        <th class="px-6 py-3 font-medium text-right">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($roles as $role)
                        <tr class="border-b border-gray-50 last:border-0 hover:bg-gray-50">
                            <td class="px-6 py-4 font-medium text-gray-800">{{ $role->name }}</td>
                            <td class="px-6 py-4">
                                <span @class([
                                    'inline-block rounded-full text-xs font-medium px-3 py-1',
                                    'bg-green-50 text-green-600' => $role->status === 'Active',
                                    'bg-gray-100 text-gray-500' => $role->status !== 'Active',
                                ])>
                                    {{ $role->status }}
                                </span>
                            </td>
                            <td class="px-6 py-4">
                                <div class="flex items-center justify-end gap-2">
                                    <a href="{{ route('roles.edit', $role) }}"
                                        class="inline-flex items-center justify-center w-8 h-8 rounded-lg border border-gray-200 hover:bg-gray-50">
                                        <i class="fa-solid fa-pen"></i>
                                    </a>
                                    <form action="{{ route('roles.destroy', $role) }}" method="POST"
                                        onsubmit="return confirm('Delete this role? Users assigned to it will lose this role.');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                            class="inline-flex items-center justify-center w-8 h-8 rounded-lg border border-gray-200 hover:bg-red-50">
                                            <i class="fa-solid fa-trash"></i>

                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="3" class="px-6 py-10 text-center text-gray-400">
                                No roles found. Click "+ Add Role" to create the first one.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="mt-4">
            {{ $roles->links() }}
        </div>
    </div>
@endsection
