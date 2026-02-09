@extends('admin.layouts.app')

@section('content')

<div class="flex justify-between mb-4">
    <h2 class="text-xl font-bold">Permissions</h2>

    @can('permission.create')
    <a href="{{ route('admin.permissions.create') }}"
       class="bg-green-600 text-dark px-4 py-2 rounded">
        Add Permission
    </a>
    @endcan
</div>

<div class="bg-white p-4 rounded shadow">
<table class="datatable w-full">
    <thead>
        <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Guard</th>
            <th>Actions</th>
        </tr>
    </thead>

    <tbody>
        @foreach($permissions as $permission)
        <tr>
            <td>{{ $permission->id }}</td>
            <td>{{ $permission->name }}</td>
            <td>{{ $permission->guard_name }}</td>
            <td class="space-x-1">
                @can('permission.view')
                <a href="{{ route('admin.permissions.show',$permission) }}"
                   class="bg-blue-600 text-dark px-2 py-1 rounded">View</a>
                @endcan

                @can('permission.edit')
                <a href="{{ route('admin.permissions.edit',$permission) }}"
                   class="bg-yellow-500 text-dark px-2 py-1 rounded">Edit</a>
                @endcan

                @can('permission.delete')
                <form method="POST"
                      action="{{ route('admin.permissions.destroy',$permission) }}"
                      class="inline">
                    @csrf @method('DELETE')
                    <button class="bg-red-600 text-dark px-2 py-1 rounded"
                        onclick="return confirm('Delete this permission?')">
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
