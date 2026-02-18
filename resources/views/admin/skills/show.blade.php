@extends('admin.layouts.app')

@section('content')

<div class="max-w-5xl mx-auto mt-8">

<div class="bg-white rounded-3xl shadow-xl">

<div class="bg-gradient-to-r from-purple-500 to-indigo-500
text-white p-8">

<h2 class="text-2xl font-bold">
{{ $skill->name }}
</h2>

<p>{{ $skill->category }}</p>

</div>

<div class="p-8 space-y-6">

<div>
<h4 class="font-semibold text-gray-600">Description</h4>
<p>{{ $skill->description ?? 'N/A' }}</p>
</div>

<div class="grid grid-cols-2 gap-6">

<div>
<h4>Jobs Using This Skill</h4>
<p>{{ $skill->jobsCount() }}</p>
</div>

<div>
<h4>Candidates Having This Skill</h4>
<p>{{ $skill->candidatesCount() }}</p>
</div>

</div>

<div>
<h4>Status</h4>

@if($skill->is_active)
<span class="badge bg-green-100 text-green-700">
Active
</span>
@else
<span class="badge bg-red-100 text-red-700">
Inactive
</span>
@endif

</div>

</div>

</div>

</div>

@endsection
