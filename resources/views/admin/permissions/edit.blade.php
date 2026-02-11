@extends('admin.layouts.app')

@section('content')

<div class="max-w-2xl mx-auto mt-8">

    <!-- Card -->
    <div class="bg-[#f8f7ff] border border-[#e9e7ff] rounded-3xl shadow-lg p-8">

        <!-- Heading -->
        <h2 class="text-2xl font-bold text-[#8b5cf6] mb-6">
            ✏️ Edit Permission
        </h2>

        <form method="POST" action="{{ route('admin.permissions.update',$permission) }}">
        @csrf
        @method('PUT')

            <!-- Permission Name -->
            <div class="mb-6">
                <label class="block font-semibold text-gray-700 mb-2">
                    Permission Name
                </label>

                <input name="name"
                       value="{{ $permission->name }}"
                       class="w-full px-4 py-3 rounded-xl 
                              border border-[#e9e7ff] 
                              focus:outline-none 
                              focus:ring-2 
                              focus:ring-[#8b5cf6] 
                              bg-white 
                              transition"
                       required>
            </div>

            <!-- Buttons -->
            <div class="flex items-center gap-4">

                <button type="submit"
                        class="bg-[#a78bfa] 
                               hover:bg-[#8b5cf6] 
                               text-white 
                               px-6 py-3 
                               rounded-xl 
                               transition 
                               duration-200 
                               shadow-md">
                    💾 Update
                </button>

                <a href="{{ route('admin.permissions.index') }}"
                   class="px-6 py-3 rounded-xl 
                          border border-[#e9e7ff] 
                          text-gray-600 
                          hover:bg-[#ede9fe] 
                          transition">
                    Cancel
                </a>

            </div>

        </form>

    </div>

</div>

@endsection
