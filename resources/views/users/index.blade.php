@extends('layouts.app')

@section('content')
    <div class="p-6">

        <div class="flex items-center justify-between mb-6">
            <h1 class="text-lg font-semibold text-gray-800">Users</h1>
        </div>

        @if (session('success'))
            <div class="mb-4 rounded-lg bg-green-50 border border-green-200 text-green-700 px-4 py-2 text-sm">
                {{ session('success') }}
            </div>
        @endif

        <div class="mb-1">
            <h2 class="text-2xl font-bold text-gray-900">Users </h2>
            <p class="text-gray-500 text-sm mt-1">Team members and their role-based access.</p>
        </div>

        <div class="flex items-center justify-between mt-6 mb-4">
            <div class="flex items-center gap-3">
                <form method="GET" action="{{ route('users.index') }}">
                    <input type="text" name="q" value="{{ $search }}" placeholder="Search users & roles..."
                        class="w-72 rounded-lg border border-gray-300 px-4 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-400"
                        onchange="this.form.submit()">
                </form>
                <span class="rounded-lg border border-gray-300 px-4 py-2 text-sm text-gray-600 bg-white">
                    {{ $users->total() }} records
                </span>
            </div>

            <div class="flex items-center gap-2">
                <a href="{{ route('roles.index') }}"
                    class="inline-flex items-center gap-2 rounded-lg border border-gray-300 text-gray-700 font-medium px-4 py-2 text-sm hover:bg-gray-50">
                    Manage Roles
                </a>
                <a href="{{ route('users.create') }}"
                    class="inline-flex items-center gap-2 rounded-lg bg-blue-500 hover:bg-blue-600 text-white font-medium px-4 py-2 text-sm shadow-sm">
                    + Add User
                </a>
            </div>
        </div>

        <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
            <table class="min-w-full text-sm">
                <thead>
                    <tr class="text-left text-gray-500 border-b border-gray-100">
                        <th class="px-6 py-3 font-medium">Name</th>
                        <th class="px-6 py-3 font-medium">Email</th>
                        <th class="px-6 py-3 font-medium">Role</th>
                        <th class="px-6 py-3 font-medium">Branch</th>
                        <th class="px-6 py-3 font-medium">Status</th>
                        <th class="px-6 py-3 font-medium text-right">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($users as $user)
                        <tr class="border-b border-gray-50 last:border-0 hover:bg-gray-50">
                            <td class="px-6 py-4  font-medium text-gray-700">
                                <a href="{{ route('users.show', $user) }}">{{ $user->name }}</a>
                            </td>
                            <td class="px-6 py-4  font-medium text-gray-700">{{ $user->email }}</td>
                            <td class="px-6 py-4">
                                @if ($user->role)
                                    <span
                                        class="inline-block rounded-full   bg-blue-50 text-blue-600 font-medium px-3 py-1">
                                        {{ $user->role->name }}
                                    </span>
                                @else
                                    <span class="text-gray-400 text-xs">—</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 text-gray-700">
                                {{ $user->branch->name ?? '—' }}
                            </td>
                            <td class="px-6 py-4">
                                <span @class([
                                    'inline-block rounded-full text-xs font-medium px-3 py-1',
                                    'bg-green-50 text-green-600' => $user->status === 'Active',
                                    'bg-gray-100 text-gray-500' => $user->status !== 'Active',
                                ])>
                                    {{ $user->status }}
                                </span>
                            </td>
                            <td class="px-6 py-4">
                                <div class="flex items-center justify-end gap-2">
                                    <a href="{{ route('users.edit', $user) }}"
                                        class="inline-flex items-center justify-center w-8 h-8 rounded-lg border border-gray-200 hover:bg-gray-50">
                                        <i class="fa-solid fa-pen"></i>
                                    </a>
                                    <form action="{{ route('users.destroy', $user) }}" method="POST"
                                        onsubmit="return confirm('Delete this user?');">
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
                            <td colspan="6" class="px-6 py-10 text-center text-gray-400">
                                No users found. Click "+ Add User" to create the first record.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="mt-4">
            {{ $users->links() }}
        </div>
    </div>
@endsection
