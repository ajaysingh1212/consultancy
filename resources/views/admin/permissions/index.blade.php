@extends('admin.layouts.app')

@section('content')

<div class="max-w-6xl mx-auto mt-8 bg-[#f5f3ff] p-6 rounded-3xl">

    <!-- Header -->
    <div class="flex justify-between items-center mb-6">
        <h2 class="text-2xl font-bold text-[#8b5cf6]">
            💜 Permissions
        </h2>

        @can('permission.create')
        <a href="{{ route('admin.permissions.create') }}"
           class="bg-[#8b5cf6] hover:bg-[#a78bfa] text-white 
                  px-5 py-2 rounded-xl shadow-md transition duration-200">
            ➕ Add Permission
        </a>
        @endcan
    </div>

    <!-- Card -->
    <div class="bg-white border border-[#e9e5ff] rounded-3xl shadow-lg p-6">

        <table class="w-full text-left">
            <thead>
                <tr class="text-[#8b5cf6] border-b border-[#e9e5ff]">
                    <th class="py-3">ID</th>
                    <th>Name</th>
                    <th>Guard</th>
                    <th class="text-center">Actions</th>
                </tr>
            </thead>

            <tbody class="text-[#2f2f33]">

                @foreach($permissions as $permission)
                <tr class="border-b border-[#e9e5ff] hover:bg-[#ede9fe] transition">

                    <td class="py-3">{{ $permission->id }}</td>
                    <td class="font-medium">{{ $permission->name }}</td>
                    <td>{{ $permission->guard_name }}</td>

                    <td class="text-center space-x-2">

                        {{-- View --}}
                        @can('permission.view')
                        <a href="{{ route('admin.permissions.show',$permission) }}"
                           class="inline-flex items-center justify-center
                                  w-9 h-9 rounded-full
                                  bg-white border border-[#e9e5ff]
                                  hover:bg-[#ede9fe] shadow-sm transition"
                           title="View">
                            👁
                        </a>
                        @endcan

                        {{-- Edit --}}
                        @can('permission.edit')
                        <a href="{{ route('admin.permissions.edit',$permission) }}"
                           class="inline-flex items-center justify-center
                                  w-9 h-9 rounded-full
                                  bg-white border border-[#e9e5ff]
                                  hover:bg-[#ede9fe] shadow-sm transition"
                           title="Edit">
                            ✏️
                        </a>
                        @endcan

                        {{-- Delete --}}
                        @can('permission.delete')
                        <form method="POST"
                              action="{{ route('admin.permissions.destroy',$permission) }}"
                              class="inline">
                            @csrf @method('DELETE')
                            <button type="submit"
                                class="inline-flex items-center justify-center
                                       w-9 h-9 rounded-full
                                       bg-white border border-[#e9e5ff]
                                       hover:bg-[#ede9fe] shadow-sm transition"
                                onclick="return confirm('Delete this permission?')"
                                title="Delete">
                                🗑
                            </button>
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
