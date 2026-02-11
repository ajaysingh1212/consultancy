@extends('admin.layouts.app')

@section('content')

<div class="max-w-2xl mx-auto mt-8">

    <!-- Card -->
    <div class="bg-[#f8f7ff] border border-[#e9e7ff] rounded-3xl shadow-lg p-8">

        <!-- Heading -->
        <h2 class="text-2xl font-bold text-[#8b5cf6] mb-6">
            👁 Permission Details
        </h2>

        <!-- Info Box -->
        <div class="space-y-4 text-gray-700">

            <div class="bg-white rounded-xl px-5 py-4 border border-[#e9e7ff]">
                <p class="text-sm text-gray-500">Permission Name</p>
                <p class="font-semibold text-lg text-[#8b5cf6]">
                    {{ $permission->name }}
                </p>
            </div>

            <div class="bg-white rounded-xl px-5 py-4 border border-[#e9e7ff]">
                <p class="text-sm text-gray-500">Guard</p>
                <p class="font-semibold text-lg">
                    {{ $permission->guard_name }}
                </p>
            </div>

        </div>

        <!-- Back Button -->
        <div class="mt-8">
            <a href="{{ route('admin.permissions.index') }}"
               class="inline-flex items-center gap-2 
                      px-5 py-2 rounded-xl 
                      border border-[#e9e7ff] 
                      text-[#8b5cf6] 
                      hover:bg-[#ede9fe] 
                      transition">
                ← Back
            </a>
        </div>

    </div>

</div>

@endsection
