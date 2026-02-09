@extends('admin.layouts.app')

@section('content')

<h2 class="text-xl font-bold mb-4">Role Details</h2>

<div class="bg-white p-4 rounded shadow">

<p class="mb-2">
    <strong>Name:</strong> {{ $role->name }}
</p>

<p class="mb-2">
    <strong>Permissions:</strong>
</p>

<ul class="list-disc ml-6">
    @foreach($role->permissions as $permission)
        <li>{{ $permission->name }}</li>
    @endforeach
</ul>

</div>

<a href="{{ route('admin.roles.index') }}"
   class="inline-block mt-4 text-blue-600">
    ← Back
</a>

@endsection
