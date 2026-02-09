@extends('admin.layouts.app')

@section('content')

<h2 class="text-xl font-bold mb-4">User Details</h2>

<div class="bg-white p-4 rounded shadow">

<p class="mb-2">
    <strong>Name:</strong> {{ $user->name }}
</p>

<p class="mb-2">
    <strong>Email:</strong> {{ $user->email }}
</p>

<p class="mb-2">
    <strong>Roles:</strong>
</p>

<ul class="list-disc ml-6">
    @foreach($user->roles as $role)
        <li>{{ $role->name }}</li>
    @endforeach
</ul>

</div>

<a href="{{ route('admin.users.index') }}"
   class="inline-block mt-4 text-blue-600">
   ← Back
</a>

@endsection
