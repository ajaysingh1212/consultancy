@extends('admin.layouts.app')

@section('content')

<div class="max-w-4xl mx-auto mt-12">

    <!-- Header -->
    <div class="mb-8">
        <h2 class="text-3xl font-bold text-[#9f1239] flex items-center gap-2">
            ✏️ Edit Expense Category
        </h2>
        <p class="text-gray-500 mt-2">
            Update category information.
        </p>
    </div>

    <!-- Card -->
    <div class="bg-white rounded-3xl shadow-2xl p-8 border border-[#f1dadd]">

        <form method="POST"
              action="{{ route('admin.expense.categories.update',$expenseCategory) }}">
            @csrf
            @method('PUT')

            <!-- Category Name -->
            <div class="mb-6">
                <label class="block text-sm font-semibold text-gray-600 mb-2">
                    Category Name
                </label>

                <input type="text"
                       name="name"
                       value="{{ old('name',$expenseCategory->name) }}"
                       class="w-full border rounded-xl px-4 py-3 focus:ring-2 focus:ring-[#9f1239] outline-none">

                @error('name')
                    <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Status -->
            <div class="mb-8">
                <label class="block text-sm font-semibold text-gray-600 mb-2">
                    Status
                </label>

                <select name="status"
                        class="w-full border rounded-xl px-4 py-3 focus:ring-2 focus:ring-[#9f1239]">

                    <option value="1" {{ $expenseCategory->status ? 'selected' : '' }}>
                        Active
                    </option>

                    <option value="0" {{ !$expenseCategory->status ? 'selected' : '' }}>
                        Inactive
                    </option>

                </select>
            </div>

            <!-- Buttons -->
            <div class="flex justify-between">

                <form method="POST"
                      action="{{ route('admin.expense.categories.destroy',$expenseCategory) }}">
                    @csrf
                    @method('DELETE')
                    <button class="bg-red-600 hover:bg-red-700 text-white px-5 py-2 rounded-xl">
                        🗑 Delete
                    </button>
                </form>

                <div class="space-x-3">
                    <a href="{{ route('admin.expense.categories.index') }}"
                       class="px-6 py-3 rounded-xl border border-gray-300 hover:bg-gray-100">
                        Cancel
                    </a>

                    <button class="bg-[#9f1239] hover:bg-[#7c0f2c] text-white px-6 py-3 rounded-xl shadow-lg">
                        Update Category
                    </button>
                </div>

            </div>

        </form>

    </div>

</div>

@endsection
