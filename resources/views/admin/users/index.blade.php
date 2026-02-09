@extends('admin.layouts.app')

@section('content')

<div class="flex justify-between mb-4">
    <h2 class="text-xl font-bold">Users</h2>

    @can('user.create')
    <a href="{{ route('admin.users.create') }}"
    class="btn btn-outline-secondary text-black px-4 py-2 rounded">
        Add User
    </a>
    @endcan

</div>

<div class="bg-white p-4 rounded shadow">
<table class="datatable w-full">
    <thead>
        <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Email</th>
            <th>Roles</th>
            <th>Actions</th>
        </tr>
    </thead>

    <tbody>
        @foreach($users as $user)
        <tr>
            <td>{{ $user->id }}</td>
            <td>{{ $user->name }}</td>
            <td>{{ $user->email }}</td>
            <td>
                @foreach($user->roles as $role)
                    <span class="bg-blue-500 text-dark px-2 py-1 rounded text-xs">
                        {{ $role->name }}
                    </span>
                @endforeach
            </td>
            <td class="space-x-1">
                @can('user.view')
                <a href="{{ route('admin.users.show',$user) }}"
                   class="bg-blue-600 text-dark px-2 py-1 rounded">
                   View
                </a>
                @endcan

                @can('user.edit')
                <a href="{{ route('admin.users.edit',$user) }}"
                   class="bg-yellow-500 text-dark px-2 py-1 rounded">
                   Edit
                </a>
                @endcan

                @can('user.delete')
                <form method="POST"
                      action="{{ route('admin.users.destroy',$user) }}"
                      class="inline">
                    @csrf @method('DELETE')
                    <button
                      onclick="return confirm('Delete this user?')"
                      class=" text-dark px-2 py-1 rounded">
                      Delete
                    </button>
                </form>
                @endcan
            </td>
        </tr>
        @endforeach
    </tbody>
</table>
</div>

@endsection
