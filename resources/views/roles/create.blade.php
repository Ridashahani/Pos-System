@extends('layouts.app')

@section('content')
    <div class="min-h-screen bg-gray-500/40 flex items-center justify-center p-6">
        <div class="bg-white rounded-2xl shadow-xl w-full max-w-md overflow-hidden">

            <div class="flex items-center justify-between px-6 py-5 border-b border-gray-100">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-xl bg-blue-500 flex items-center justify-center text-white text-lg">
                        <i class="fa-duotone fa-solid fa-person-military-to-person"></i>
                    </div>
                    <div>
                        <p class="text-xs font-semibold text-blue-500 tracking-wide">
                            {{ $roleRecord->exists ? 'EDIT RECORD' : 'NEW RECORD' }}
                        </p>
                        <h2 class="text-lg font-bold text-gray-900">
                            {{ $roleRecord->exists ? 'Edit' : 'Add' }} Role
                        </h2>
                    </div>
                </div>
                <a href="{{ route('roles.index') }}"
                    class="inline-flex items-center gap-1 text-sm text-gray-600 border border-gray-300 rounded-lg px-3 py-1.5 hover:bg-gray-50">
                    ← Back
                </a>
            </div>

            <form action="{{ $roleRecord->exists ? route('roles.update', $roleRecord) : route('roles.store') }}"
                method="POST" class="px-6 py-6">
                @csrf
                @if ($roleRecord->exists)
                    @method('PUT')
                @endif

                <div class="space-y-5">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Role Name</label>
                        <input type="text" name="name" value="{{ old('name', $roleRecord->name) }}"
                            placeholder="e.g. Supervisor"
                            class="w-full rounded-lg border border-gray-300 px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-400">
                        @error('name')
                            <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Status</label>
                        <select name="status"
                            class="w-full rounded-lg border border-gray-300 px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-400">
                            @foreach (['Active', 'Inactive'] as $status)
                                <option value="{{ $status }}" @selected(old('status', $roleRecord->status ?? 'Active') === $status)>
                                    {{ $status }}
                                </option>
                            @endforeach
                        </select>
                        @error('status')
                            <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div class="flex items-center justify-end gap-3 mt-8 pt-5 border-t border-gray-100">
                    <a href="{{ route('roles.index') }}"
                        class="rounded-lg border border-gray-300 px-5 py-2.5 text-sm font-medium text-gray-700 hover:bg-gray-50">
                        Cancel
                    </a>
                    <button type="submit"
                        class="rounded-lg bg-blue-500 hover:bg-blue-600 px-5 py-2.5 text-sm font-semibold text-white shadow-sm">
                        Save Record
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection
