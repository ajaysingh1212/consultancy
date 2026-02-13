@extends('admin.layouts.app')

@section('content')

<div class="max-w-6xl mx-auto mt-10">

    <div class="flex justify-between items-center mb-6">
        <h2 class="text-2xl font-bold text-[#9f1239]">
            📂 Expense Categories
        </h2>

        @can('expense.category.create')
        <a href="{{ route('admin.expense.categories.create') }}"
           class="bg-indigo-600 text-white px-5 py-2 rounded-xl shadow">
            ➕ Add Category
        </a>
        @endcan
    </div>

    <div class="bg-white rounded-3xl shadow-xl p-6">

        <table class=" datatable w-full text-sm">
            <thead class="border-b">
                <tr>
                    <th>Name</th>
                    <th>Status</th>
                    <th class="text-center">Action</th>
                </tr>
            </thead>

            <tbody>
                @foreach($categories as $category)
                <tr class="border-b hover:bg-gray-50">

                    <td class="py-3 font-semibold">
                        {{ $category->name }}
                    </td>

                    <td>
                        @if($category->status)
                            <span class="bg-green-100 text-green-700 px-3 py-1 rounded-full text-xs">
                                Active
                            </span>
                        @else
                            <span class="bg-gray-100 text-gray-500 px-3 py-1 rounded-full text-xs">
                                Inactive
                            </span>
                        @endif
                    </td>

                    <td class="text-center space-x-2">

                        <a href="{{ route('admin.expense.categories.show',$category) }}"
                           class="bg-blue-100 px-3 py-1 rounded-lg">👁</a>

                        <a href="{{ route('admin.expense.categories.edit',$category) }}"
                           class="bg-yellow-100 px-3 py-1 rounded-lg">✏️</a>

                        <form method="POST"
                              action="{{ route('admin.expense.categories.destroy',$category) }}"
                              class="inline">
                            @csrf @method('DELETE')
                            <button class="bg-red-100 px-3 py-1 rounded-lg">
                                🗑
                            </button>
                        </form>

                    </td>

                </tr>
                @endforeach
            </tbody>

        </table>

        <div class="mt-4">
            {{ $categories->links() }}
        </div>

    </div>

</div>

@endsection
