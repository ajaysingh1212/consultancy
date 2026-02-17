@extends('admin.layouts.app')

@section('content')

<div class="max-w-7xl mx-auto mt-8">

<h2 class="text-2xl font-bold text-[#8b5cf6] mb-6">
🧠 Candidate Skills
</h2>

<div class="card">

<table class="datatable w-full">

<thead>
<tr class="text-[#8b5cf6] border-b">
<th>#</th>
<th>Candidate</th>
<th>Total Skills</th>
<th>Actions</th>
</tr>
</thead>

<tbody>

@foreach($candidates as $candidate)

<tr class="border-b hover:bg-[#ede9fe]">
<td>#{{ $candidate->id }}</td>
<td>{{ $candidate->full_name }}</td>
<td>{{ $candidate->skills->count() }}</td>

<td>
<a href="{{ route('admin.candidate-skills.edit',$candidate) }}"
class="action-btn bg-purple-100 text-purple-600"
data-text="Manage">
⚙
</a>
</td>

</tr>

@endforeach

</tbody>
</table>

</div>
</div>

@endsection
