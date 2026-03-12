@extends('admin.layouts.app')

@section('content')

<div class="max-w-6xl mx-auto mt-10">

    {{-- HEADER --}}
    <div class="mb-8">
        <h2 class="text-3xl font-bold text-[#7c3aed] flex items-center gap-3">
            👤 Create User
        </h2>
        <p class="text-gray-500 mt-1">
            Add a new system user and assign roles carefully.
        </p>
    </div>

    <form method="POST"
          action="{{ route('admin.users.store') }}"
          class="bg-white p-10 rounded-3xl shadow-2xl space-y-10">

        @csrf

        {{-- ================= BASIC INFORMATION ================= --}}
        <div>
            <h3 class="text-xl font-semibold text-[#7c3aed] mb-6 border-b pb-2">
                📝 Basic Information
            </h3>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                <div>
                    <label class="font-medium">Full Name *</label>
                    <input name="name"
                           required
                           class="w-full border rounded-xl p-3 mt-2"
                           placeholder="Enter full name">
                </div>

                <div>
                    <label class="font-medium">Email Address *</label>
                    <input name="email"
                           type="email"
                           required
                           class="w-full border rounded-xl p-3 mt-2"
                           placeholder="Enter email address">
                </div>

                <div>
                    <label class="font-medium">Password *</label>
                    <input name="password"
                           type="password"
                           required
                           class="w-full border rounded-xl p-3 mt-2"
                           placeholder="Enter secure password">
                </div>

            </div>
        </div>

        {{-- ================= ROLE ASSIGNMENT ================= --}}
        <div>
            <h3 class="text-xl font-semibold text-[#7c3aed] mb-6 border-b pb-2">
                🔐 Role Assignment
            </h3>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">

                @foreach($roles as $role)
                <label class="flex items-center gap-3 bg-gray-50 p-4 rounded-xl cursor-pointer hover:bg-purple-50 transition">
                    <input type="checkbox"
                           name="roles[]"
                           value="{{ $role->name }}"
                           class="w-4 h-4 accent-purple-600">
                    <span class="font-medium text-gray-700">
                        {{ ucfirst($role->name) }}
                    </span>
                </label>
                @endforeach
            </div>
        </div>

        {{-- ================= SUBMIT SECTION ================= --}}
        <div class="flex justify-end gap-4 pt-4">

            <a href="{{ route('admin.users.index') }}"
               class="px-6 py-3 rounded-2xl border border-gray-300 bg-white hover:bg-gray-100 transition">
                Cancel
            </a>

            <button type="submit"
                class="bg-[#7c3aed] hover:bg-[#6d28d9]
                       text-white px-10 py-3 rounded-2xl shadow-lg transition">
                💾 Save User
            </button>

        </div>

    </form>

</div>

@endsection