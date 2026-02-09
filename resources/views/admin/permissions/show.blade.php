@extends('admin.layouts.app')

@section('content')

<h2 class="text-xl font-bold mb-4">Permission Details</h2>

<div class="bg-white p-4 rounded shadow">

<p class="mb-2">
    <strong>Name:</strong> {{ $permission->name }}
</p>

<p class="mb-2">
    <strong>Guard:</strong> {{ $permission->guard_name }}
</p>

</div>

<a href="{{ route('admin.permissions.index') }}"
   class="inline-block mt-4 text-blue-600">
    ← Back
</a>

@endsection
