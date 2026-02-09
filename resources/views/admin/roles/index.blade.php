@extends('admin.layouts.app')

@section('content')

<div class="flex justify-between mb-4">
    <h2 class="text-xl font-bold">Roles</h2>

    @can('role.create')
    <a href="{{ route('admin.roles.create') }}"
       class="bg-green-600 text-dark px-4 py-2 rounded">
        Add Role
    </a>
    @endcan
</div>

<div class="bg-white p-4 rounded shadow">
<table class="datatable w-full">
    <thead>
        <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Permissions</th>
            <th>Actions</th>
        </tr>
    </thead>

    <tbody>
        @foreach($roles as $role)
        <tr>
            <td>{{ $role->id }}</td>
            <td>{{ $role->name }}</td>
            <td>{{ $role->permissions->count() }}</td>
            <td class="space-x-1">
                @can('role.view')
                <a href="{{ route('admin.roles.show',$role) }}"
                   class="bg-blue-600 text-white px-2 py-1 rounded">View</a>
                @endcan

                @can('role.edit')
                <a href="{{ route('admin.roles.edit',$role) }}"
                   class="bg-yellow-500 text-white px-2 py-1 rounded">Edit</a>
                @endcan

                @can('role.delete')
                <form method="POST"
                      action="{{ route('admin.roles.destroy',$role) }}"
                      class="inline">
                    @csrf @method('DELETE')
                    <button class="bg-red-600 text-white px-2 py-1 rounded"
                        onclick="return confirm('Delete this role?')">
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
