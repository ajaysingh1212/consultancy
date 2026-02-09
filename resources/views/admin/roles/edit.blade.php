@extends('admin.layouts.app')

@section('content')

<h2 class="text-xl font-bold mb-4">Edit Role</h2>

<form method="POST" action="{{ route('admin.roles.update',$role) }}">
@csrf
@method('PUT')

<div class="mb-4">
    <label class="block font-semibold">Role Name</label>
    <input name="name"
           class="border p-2 w-full"
           value="{{ $role->name }}"
           required>
</div>

<div class="mb-4">
    <label class="block font-semibold mb-2">Permissions</label>

    <div class="grid grid-cols-3 gap-2">
        @foreach($permissions as $permission)
        <label class="flex items-center space-x-2">
            <input type="checkbox"
                   name="permissions[]"
                   value="{{ $permission->name }}"
                   {{ in_array($permission->name, $rolePermissions) ? 'checked' : '' }}>
            <span>{{ $permission->name }}</span>
        </label>
        @endforeach
    </div>
</div>

<button class="bg-blue-600 text-white px-4 py-2 rounded">
    Update
</button>

<a href="{{ route('admin.roles.index') }}"
   class="ml-2 text-gray-600">
    Cancel
</a>

</form>

@endsection
