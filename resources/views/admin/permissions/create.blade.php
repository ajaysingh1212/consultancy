@extends('admin.layouts.app')

@section('content')

<div class="max-w-2xl mx-auto mt-8">

    <!-- Card -->
    <div class="bg-[#fff1f3] border border-[#f1dadd] rounded-3xl shadow-lg p-8">

        <!-- Heading -->
        <h2 class="text-2xl font-bold text-[#9f1239] mb-6">
            ✨ Create Permission
        </h2>

        <form method="POST" action="{{ route('admin.permissions.store') }}">
        @csrf

            <!-- Permission Name -->
            <div class="mb-6">
                <label class="block font-semibold text-[#2f2f33] mb-2">
                    Permission Name
                </label>

                <input name="name"
                       class="w-full px-4 py-3 rounded-xl border border-[#f1dadd] 
                              focus:outline-none focus:ring-2 focus:ring-[#9f1239] 
                              bg-white placeholder-gray-400"
                       placeholder="e.g. user.create"
                       required>
            </div>

            <!-- Buttons -->
            <div class="flex items-center gap-4">

                <button type="submit"
                        class="bg-[#9f1239] hover:bg-[#881337] 
                               text-white px-6 py-3 rounded-xl 
                               transition duration-200 shadow-md">
                    💾 Save
                </button>

                <a href="{{ route('admin.permissions.index') }}"
                   class="px-6 py-3 rounded-xl border border-[#f1dadd] 
                          text-[#2f2f33] hover:bg-[#fde2e6] transition">
                    Cancel
                </a>

            </div>

        </form>

    </div>

</div>

@endsection
