@extends('layouts.app')

@section('content')
    <div class="p-6">
        <div class="flex justify-between items-center mb-6">
            <div>
                <p class="text-xs text-blue-500 font-semibold uppercase">New Record</p>
                <h1 class="text-2xl font-semibold text-gray-800">Add — Supplier</h1>
                <p class="text-sm text-gray-500 mt-1">Create a new supplier.</p>
            </div>
            <a href="{{ route('suppliers.index') }}"
                class="border border-gray-300 px-4 py-2 rounded-lg text-sm hover:bg-gray-50">← Back</a>
        </div>

        @if ($errors->any())
            <div class="bg-red-50 border border-red-200 text-red-700 text-sm px-4 py-3 rounded-lg mb-4">
                <ul class="list-disc pl-5">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('suppliers.store') }}" method="POST">
            @csrf

            <div class="bg-white rounded-xl shadow-sm p-6 max-w-xl">

                <label class="text-sm font-medium text-gray-700 block mb-2">Supplier Name *</label>
                <input type="text" name="name" value="{{ old('name') }}"
                    class="border border-gray-300 rounded-lg px-3 py-2 w-full text-sm mb-4">

                <label class="text-sm font-medium text-gray-700 block mb-2">Phone *</label>
                <input type="text" name="phone" value="{{ old('phone') }}"
                    class="border border-gray-300 rounded-lg px-3 py-2 w-full text-sm mb-4">

                <label class="text-sm font-medium text-gray-700 block mb-2">Address</label>
                <input type="text" name="address" value="{{ old('address') }}"
                    class="border border-gray-300 rounded-lg px-3 py-2 w-full text-sm mb-4">

                <button type="submit"
                    class="bg-blue-500 hover:bg-blue-600 text-white text-sm font-medium px-4 py-2 rounded-lg">
                    Save Supplier
                </button>
            </div>
        </form>
    </div>
@endsection
