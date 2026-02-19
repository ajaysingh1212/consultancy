@extends('admin.layouts.app')

@section('content')

<div class="max-w-4xl mx-auto mt-10">

    <!-- Header -->
    <div class="flex justify-between items-center mb-8">
        <h2 class="text-2xl font-bold text-[#8b5cf6] flex items-center gap-2">
            ➕ Create Expense Category
        </h2>

        <a href="{{ route('admin.expense.categories.index') }}"
           class="bg-white border border-[#e9e7ff]
                  text-[#8b5cf6] px-5 py-2.5
                  rounded-xl shadow-sm
                  hover:bg-[#ede9fe]
                  transition flex items-center gap-2">
            📋 View All
        </a>
    </div>

    <!-- Card -->
    <form method="POST"
          action="{{ route('admin.expense.categories.store') }}"
          class="bg-[#f8f7ff] border border-[#e9e7ff]
                 rounded-3xl shadow-xl p-8">

        @csrf

        <div class="space-y-6">

            <!-- Category Name -->
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-2">
                    🏷 Category Name
                </label>
                <input type="text"
                       name="name"
                       value="{{ old('name') }}"
                       placeholder="Enter category name"
                       class="w-full px-4 py-3 rounded-xl
                              border border-[#e9e7ff]
                              focus:ring-2 focus:ring-[#8b5cf6]
                              focus:outline-none
                              bg-white">

                @error('name')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Status -->
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-2">
                    🔄 Status
                </label>

                <select name="status"
                        class="w-full px-4 py-3 rounded-xl
                               border border-[#e9e7ff]
                               focus:ring-2 focus:ring-[#8b5cf6]
                               focus:outline-none
                               bg-white">
                    <option value="1">Active</option>
                    <option value="0">Inactive</option>
                </select>
            </div>

        </div>

        <!-- Buttons -->
        <div class="mt-8 flex gap-4">

            <button type="submit"
                    class="bg-[#9f7aea] hover:bg-[#7c3aed]
                           text-white px-6 py-3
                           rounded-xl shadow-md
                           transition flex items-center gap-2">
                💾 Save Category
            </button>

            <a href="{{ route('admin.expense.categories.index') }}"
               class="px-6 py-3 rounded-xl
                      border border-[#e9e7ff]
                      bg-white
                      hover:bg-[#ede9fe]
                      transition flex items-center gap-2">
                ❌ Cancel
            </a>

        </div>

    </form>

</div>

@endsection
