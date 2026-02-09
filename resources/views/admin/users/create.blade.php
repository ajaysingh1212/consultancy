@extends('admin.layouts.app')

@section('content')

<h2 class="text-xl font-bold mb-4">Create User</h2>

<form method="POST" action="{{ route('admin.users.store') }}">
@csrf

<div class="mb-4">
    <label class="block font-semibold">Name</label>
    <input name="name"
           class="border p-2 w-full"
           required>
</div>

<div class="mb-4">
    <label class="block font-semibold">Email</label>
    <input name="email"
           type="email"
           class="border p-2 w-full"
           required>
</div>

<div class="mb-4">
    <label class="block font-semibold">Password</label>
    <input name="password"
           type="password"
           class="border p-2 w-full"
           required>
</div>

<div class="mb-4">
    <label class="block font-semibold mb-2">Roles</label>
    <div class="grid grid-cols-3 gap-2">
        @foreach($roles as $role)
        <label class="flex items-center space-x-2">
            <input type="checkbox"
                   name="roles[]"
                   value="{{ $role->name }}">
            <span>{{ $role->name }}</span>
        </label>
        @endforeach
    </div>
</div>

<button class="bg-blue-600 text-white px-4 py-2 rounded">
    Save
</button>

<a href="{{ route('admin.users.index') }}"
   class="ml-2 text-gray-600">
   Cancel
</a>

</form>

@endsection
