@extends('admin.layouts.app')

@section('content')

<div class="max-w-7xl mx-auto mt-8">

<div class="flex justify-between items-center mb-6">
    <h2 class="text-2xl font-bold text-[#8b5cf6]">
        🧠 Skills
    </h2>

    @can('skill.manage')
    <a href="{{ route('admin.skills.create') }}"
       class="bg-[#8b5cf6] text-white px-5 py-2 rounded-xl shadow-md">
        ➕ Add Skill
    </a>
    @endcan
</div>

<div class="bg-[#f8f7ff] border border-[#e9e7ff]
            rounded-3xl shadow-lg p-6">

<table class="datatable w-full">

<thead>
<tr class="text-[#8b5cf6] border-b border-[#e9e7ff]">
<th>#</th>
<th>Name</th>
<th>Category</th>
<th>Jobs</th>
<th>Candidates</th>
<th>Status</th>
<th>Actions</th>
</tr>
</thead>

<tbody>

@foreach($skills as $skill)

<tr class="border-b hover:bg-[#ede9fe] transition">

<td>#{{ $skill->id }}</td>

<td class="font-semibold">{{ $skill->name }}</td>

<td>{{ $skill->category ?? '-' }}</td>

<td>
<span class="badge bg-indigo-100 text-indigo-700">
{{ $skill->jobsCount() }}
</span>
</td>

<td>
<span class="badge bg-purple-100 text-purple-700">
{{ $skill->candidatesCount() }}
</span>
</td>

<td>
@if($skill->is_active)
<span class="badge bg-green-100 text-green-700">
Active
</span>
@else
<span class="badge bg-red-100 text-red-700">
Inactive
</span>
@endif
</td>

<td class="space-x-2 text-center">

<a href="{{ route('admin.skills.show',$skill) }}"
class="action-btn bg-blue-100 text-blue-600"
data-text="View">👁</a>

<a href="{{ route('admin.skills.edit',$skill) }}"
class="action-btn bg-yellow-100 text-yellow-600"
data-text="Edit">✏</a>

<form action="{{ route('admin.skills.destroy',$skill) }}"
method="POST" class="inline">
@csrf @method('DELETE')
<button class="action-btn bg-red-100 text-red-600"
data-text="Delete">🗑</button>
</form>

</td>

</tr>

@endforeach

</tbody>
</table>

</div>
</div>

@endsection
