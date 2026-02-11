@extends('admin.layouts.app')

@section('content')

<div class="max-w-6xl mx-auto mt-8">

    <!-- Header -->
    <div class="flex justify-between items-center mb-6">
        <h2 class="text-2xl font-bold text-[#9f1239]">
            🌸 Permissions
        </h2>

        @can('permission.create')
        <a href="{{ route('admin.permissions.create') }}"
           class="bg-[#9f1239] hover:bg-[#881337] text-white 
                  px-5 py-2 rounded-xl shadow-md transition duration-200">
            ➕ Add Permission
        </a>
        @endcan
    </div>

    <!-- Card -->
    <div class="bg-[#fff1f3] border border-[#f1dadd] rounded-3xl shadow-lg p-6">

        <table class="w-full text-left">
            <thead>
                <tr class="text-[#9f1239] border-b border-[#f1dadd]">
                    <th class="py-3">ID</th>
                    <th>Name</th>
                    <th>Guard</th>
                    <th class="text-center">Actions</th>
                </tr>
            </thead>

            <tbody class="text-[#2f2f33]">

                @foreach($permissions as $permission)
                <tr class="border-b border-[#f1dadd] hover:bg-[#fde2e6] transition">

                    <td class="py-3">{{ $permission->id }}</td>
                    <td class="font-medium">{{ $permission->name }}</td>
                    <td>{{ $permission->guard_name }}</td>

                    <td class="text-center space-x-2">

                        {{-- View --}}
                        @can('permission.view')
                        <a href="{{ route('admin.permissions.show',$permission) }}"
                           class="inline-flex items-center justify-center
                                  w-9 h-9 rounded-full
                                  bg-white border border-[#f1dadd]
                                  hover:bg-[#fde2e6] shadow-sm transition"
                           title="View">
                            👁
                        </a>
                        @endcan

                        {{-- Edit --}}
                        @can('permission.edit')
                        <a href="{{ route('admin.permissions.edit',$permission) }}"
                           class="inline-flex items-center justify-center
                                  w-9 h-9 rounded-full
                                  bg-white border border-[#f1dadd]
                                  hover:bg-[#fde2e6] shadow-sm transition"
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
                                       bg-white border border-[#f1dadd]
                                       hover:bg-[#fde2e6] shadow-sm transition"
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
