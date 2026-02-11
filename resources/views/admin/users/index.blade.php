@extends('admin.layouts.app')

@section('content')

<div class="max-w-7xl mx-auto mt-10">

    <!-- Header -->
    <div class="flex justify-between items-center mb-6">
        <h2 class="text-2xl font-bold text-[#8b5cf6] flex items-center gap-2">
            👥 Users
        </h2>

        @can('user.create')
        <a href="{{ route('admin.users.create') }}"
           class="bg-[#9f7aea] hover:bg-[#7c3aed] 
                  text-white px-5 py-2.5 
                  rounded-xl shadow-md 
                  transition flex items-center gap-2">
            ➕ Add User
        </a>
        @endcan
    </div>

    <!-- Card -->
    <div class="bg-[#f8f7ff] border border-[#e9e7ff] 
                rounded-3xl shadow-xl p-6">

        <table class="datatable w-full text-left">
            <thead>
                <tr class="text-[#8b5cf6] border-b border-[#e9e7ff]">
                    <th class="py-3">#</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Roles</th>
                    <th class="text-center">Actions</th>
                </tr>
            </thead>

            <tbody class="text-gray-700">

                @foreach($users as $user)
                <tr class="border-b border-[#e9e7ff] 
                           hover:bg-[#ede9fe] transition">

                    <td class="py-3 font-medium">
                        #{{ $user->id }}
                    </td>

                    <td class="font-semibold">
                        {{ $user->name }}
                    </td>

                    <td>
                        {{ $user->email }}
                    </td>

                    <td>
                        @foreach($user->roles as $role)
                            <span class="bg-white border border-[#e9e7ff] 
                                         px-3 py-1 rounded-full 
                                         text-xs font-medium 
                                         mr-1">
                                {{ $role->name }}
                            </span>
                        @endforeach
                    </td>

                    <!-- Actions -->
                    <td class="text-center space-x-2">

                        @can('user.view')
                        <a href="{{ route('admin.users.show',$user) }}"
                           class="inline-flex items-center justify-center
                                  w-9 h-9 rounded-full
                                  bg-white border border-[#e9e7ff]
                                  hover:bg-[#ede9fe]
                                  shadow-sm transition"
                           title="View">
                            👁
                        </a>
                        @endcan

                        @can('user.edit')
                        <a href="{{ route('admin.users.edit',$user) }}"
                           class="inline-flex items-center justify-center
                                  w-9 h-9 rounded-full
                                  bg-white border border-[#e9e7ff]
                                  hover:bg-[#ede9fe]
                                  shadow-sm transition"
                           title="Edit">
                            ✏️
                        </a>
                        @endcan

                        @can('user.delete')
                        <form method="POST"
                              action="{{ route('admin.users.destroy',$user) }}"
                              class="inline">
                            @csrf @method('DELETE')
                            <button type="submit"
                                onclick="return confirm('Delete this user?')"
                                class="inline-flex items-center justify-center
                                       w-9 h-9 rounded-full
                                       bg-white border border-[#e9e7ff]
                                       hover:bg-[#ede9fe]
                                       shadow-sm transition"
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
