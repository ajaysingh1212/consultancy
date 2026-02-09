@extends('admin.layouts.app')

@section('content')

<h2 class="text-xl font-bold mb-4">Edit Permission</h2>

<form method="POST" action="{{ route('admin.permissions.update',$permission) }}">
@csrf
@method('PUT')

<div class="mb-4">
    <label class="block font-semibold">Permission Name</label>
    <input name="name"
           class="border p-2 w-full"
           value="{{ $permission->name }}"
           required>
</div>

<button class="bg-blue-600 text-white px-4 py-2 rounded">
    Update
</button>

<a href="{{ route('admin.permissions.index') }}"
   class="ml-2 text-gray-600">
    Cancel
</a>

</form>

@endsection
