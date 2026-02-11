@extends('admin.layouts.app')

@section('content')

<div class="max-w-4xl mx-auto mt-10">

    <!-- Card -->
    <div class="bg-[#f8f7ff] border border-[#e9e7ff] 
                rounded-3xl shadow-xl p-8">

        <!-- Header -->
        <div class="flex items-center justify-between mb-6">
            <h2 class="text-2xl font-bold text-[#8b5cf6] flex items-center gap-2">
                💜 Role Details
            </h2>

            <a href="{{ route('admin.roles.index') }}"
               class="text-[#8b5cf6] hover:text-[#6d28d9] 
                      transition flex items-center gap-1 font-medium">
                ← Back
            </a>
        </div>

        <!-- Role Name -->
        <div class="bg-white border border-[#e9e7ff] 
                    rounded-2xl p-6 mb-6 shadow-sm">

            <p class="text-gray-500 text-sm mb-1">
                Role Name
            </p>

            <p class="text-xl font-semibold text-[#6d28d9] flex items-center gap-2">
                🛡 {{ $role->name }}
            </p>

        </div>

        <!-- Permissions -->
        <div>
            <h3 class="text-lg font-semibold text-[#8b5cf6] 
                       mb-4 flex items-center gap-2">
                🔐 Assigned Permissions
            </h3>

            <div class="grid grid-cols-2 md:grid-cols-3 gap-3">

                @forelse($role->permissions as $permission)
                    <div class="bg-white border border-[#e9e7ff] 
                                rounded-xl px-4 py-2 
                                text-sm shadow-sm 
                                hover:bg-[#ede9fe] transition 
                                flex items-center gap-2">
                        ✔ {{ $permission->name }}
                    </div>
                @empty
                    <p class="text-gray-400 italic">
                        No permissions assigned.
                    </p>
                @endforelse

            </div>
        </div>

    </div>

</div>

@endsection
