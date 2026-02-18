c
@extends('admin.layouts.app')

@section('content')

<div class="max-w-7xl mx-auto mt-8">

<div class="flex justify-between items-center mb-6">
    <h2 class="text-2xl font-bold text-[#8b5cf6]">
        💼 Jobs
    </h2>

    @can('job.create')
    <a href="{{ route('admin.jobs.create') }}"
       class="bg-[#8b5cf6] text-white px-5 py-2 rounded-xl shadow-md">
        ➕ Add Job
    </a>
    @endcan
</div>

<div class="bg-[#f8f7ff] border border-[#e9e7ff]
            rounded-3xl shadow-lg p-6">

<table class="datatable w-full">

<thead>
<tr class="text-[#8b5cf6] border-b border-[#e9e7ff]">
<th>#</th>
<th>Title</th>
<th>Employer</th>
<th>Salary</th>
<th>Skills Required</th>
<th>Status</th>
<th>Actions</th>
</tr>
</thead>
<tbody>

@foreach($jobs as $job)

<tr class="border-b hover:bg-[#ede9fe] transition">

<td>#{{ $job->id }}</td>

<td class="font-semibold">
{{ $job->job_title }}
</td>

<td>
{{ $job->employer->company_name ?? '-' }}
</td>

<td>
{{ $job->salary_currency }}
{{ $job->salary_min }} - {{ $job->salary_max }}
</td>

{{-- ================= SKILLS COLUMN ================= --}}
<td>

@if($job->skills->count())

<div class="flex flex-wrap gap-2 max-w-xs">

@foreach($job->skills as $skill)

<span class="skill-badge
{{ $skill->pivot->is_mandatory ? 'mandatory' : 'optional' }}">

{{ $skill->name }}

@if($skill->pivot->experience_required)
<span class="text-xs">
({{ $skill->pivot->experience_required }}y)
</span>
@endif

</span>

@endforeach

</div>

@else

<span class="text-gray-400 text-sm">
No Skills Added
</span>

@endif

</td>

{{-- ================= STATUS ================= --}}
<td>

@if($job->is_featured)
<span class="badge bg-purple-100 text-purple-700">⭐ Featured</span>
@endif

@if($job->is_boosted)
<span class="badge bg-orange-100 text-orange-700">🚀 Boosted</span>
@endif

@if($job->is_active)
<span class="badge bg-green-100 text-green-700">Active</span>
@endif

</td>

<td class="space-x-2 text-center">

<a href="{{ route('admin.jobs.show',$job) }}"
class="action-btn bg-blue-100 text-blue-600"
data-text="View">👁</a>

<a href="{{ route('admin.jobs.edit',$job) }}"
class="action-btn bg-yellow-100 text-yellow-600"
data-text="Edit">✏</a>

<form action="{{ route('admin.jobs.destroy',$job) }}"
method="POST" class="inline">
@csrf
@method('DELETE')
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
<style>
.skill-badge{
padding:4px 10px;
border-radius:20px;
font-size:12px;
font-weight:600;
}

.mandatory{
background:#fee2e2;
color:#b91c1c;
}

.optional{
background:#e0f2fe;
color:#0369a1;
}
</style>

@endsection
