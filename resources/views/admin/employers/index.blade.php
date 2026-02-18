@extends('admin.layouts.app')

@section('content')

<div class="max-w-7xl mx-auto mt-8">

    <div class="flex justify-between items-center mb-6">
        <h2 class="text-2xl font-bold text-[#8b5cf6]">
            🏢 Employers
        </h2>

        @can('employer.create')
        <a href="{{ route('admin.employers.create') }}"
           class="bg-[#8b5cf6] hover:bg-[#7c3aed]
                  text-white px-5 py-2.5 rounded-xl shadow-md">
            ➕ Add Employer
        </a>
        @endcan
    </div>

    <div class="bg-[#f8f7ff] border border-[#e9e7ff]
                rounded-3xl shadow-lg p-6">

        <table class="datatable w-full text-left">

            <thead>
                <tr class="text-[#8b5cf6] border-b border-[#e9e7ff]">
                    <th>#ID</th>
                    <th>Company</th>
                    <th>Email</th>
                    <th>Status</th>
                    <th class="text-center">Actions</th>
                </tr>
            </thead>

            <tbody>

            @foreach($employers as $employer)

                <tr class="border-b border-[#e9e7ff]
                           hover:bg-[#ede9fe] transition">

                    <td>#{{ $employer->id }}</td>

                    <td class="font-semibold">
                        {{ $employer->company_name }}
                    </td>

                    <td>{{ $employer->company_email }}</td>

                    <td>
                        @if($employer->is_active)
                        <span class="bg-green-100 text-green-700 px-3 py-1 rounded-full text-xs">
                            Active
                        </span>
                        @else
                        <span class="bg-red-100 text-red-700 px-3 py-1 rounded-full text-xs">
                            Inactive
                        </span>
                        @endif
                    </td>

                    <td class="text-center space-x-2">

                        <a href="{{ route('admin.employers.show',$employer) }}"
                           class="action-btn bg-blue-100 text-blue-600"
                           data-text="View">👁</a>

                        @can('employer.edit')
                        <a href="{{ route('admin.employers.edit',$employer) }}"
                           class="action-btn bg-yellow-100 text-yellow-600"
                           data-text="Edit">✏</a>
                        @endcan

                        @can('employer.delete')
                        <form action="{{ route('admin.employers.destroy',$employer) }}"
                              method="POST" class="inline">
                            @csrf @method('DELETE')
                            <button class="action-btn bg-red-100 text-red-600"
                                    data-text="Delete">🗑</button>
                        </form>
                        @endcan

                    </td>

                </tr>

            @endforeach

            </tbody>

        </table>
    </div>
</div>

@endsection
