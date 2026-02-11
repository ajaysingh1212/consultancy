@extends('admin.layouts.app')

@section('content')

<div class="max-w-2xl mx-auto mt-10 bg-[#f5f3ff] p-6 rounded-3xl">

    <!-- Card -->
    <div class="bg-white border border-[#e9e5ff] rounded-3xl shadow-lg p-8">

        <!-- Heading -->
        <h2 class="text-2xl font-bold text-[#8b5cf6] mb-6">
            💜 Create Permission
        </h2>

        <form method="POST" action="{{ route('admin.permissions.store') }}">
        @csrf

            <!-- Permission Name -->
            <div class="mb-6">
                <label class="block font-semibold text-[#2f2f33] mb-2">
                    Permission Name
                </label>

                <input name="name"
                       class="w-full px-4 py-3 rounded-xl 
                              border border-[#e9e5ff] 
                              focus:outline-none 
                              focus:ring-2 focus:ring-[#8b5cf6] 
                              focus:border-[#8b5cf6]
                              bg-[#f9f8ff] placeholder-gray-400 
                              transition"
                       placeholder="e.g. user.create"
                       required>
            </div>

            <!-- Buttons -->
            <div class="flex items-center gap-4">

                <button type="submit"
                        class="bg-[#8b5cf6] hover:bg-[#7c3aed] 
                               text-white px-6 py-3 rounded-xl 
                               transition duration-200 shadow-md">
                    💾 Save
                </button>

                <a href="{{ route('admin.permissions.index') }}"
                   class="px-6 py-3 rounded-xl 
                          border border-[#e9e5ff] 
                          text-[#2f2f33] 
                          hover:bg-[#ede9fe] 
                          transition">
                    Cancel
                </a>

            </div>

        </form>

    </div>

</div>

@endsection
