@extends('admin.layouts.app')

@section('content')

<h2 class="text-xl font-bold mb-4">Create Role</h2>

<form method="POST" action="{{ route('admin.roles.store') }}">
@csrf

<div class="mb-4">
    <label class="block font-semibold">Role Name</label>
    <input name="name"
           class="border p-2 w-full"
           required>
</div>

<div class="mb-4">
    <label class="block font-semibold mb-2">Permissions</label>

    <div class="grid grid-cols-3 gap-2">
        @foreach($permissions as $permission)
        <label class="flex items-center space-x-2">
            <input type="checkbox"
                   name="permissions[]"
                   value="{{ $permission->name }}">
            <span>{{ $permission->name }}</span>
        </label>
        @endforeach
    </div>
</div>

<button class="bg-blue-600 text-white px-4 py-2 rounded">
    Save
</button>

<a href="{{ route('admin.roles.index') }}"
   class="ml-2 text-gray-600">
    Cancel
</a>

</form>

@endsection
