@extends('admin.layouts.app')

@section('content')

<div class="max-w-6xl mx-auto mt-8">

<div class="bg-white rounded-3xl shadow-xl">

<div class="bg-gradient-to-r from-purple-500 to-indigo-500 text-white p-8">

<h2 class="text-3xl font-bold">
{{ $job->job_title }}
</h2>

<p>{{ $job->location }} - {{ $job->country }}</p>

</div>

<div class="p-8 space-y-6">

<div class="grid grid-cols-2 gap-6">

<div>
<strong>Employer:</strong>
{{ $job->employer->company_name }}
</div>

<div>
<strong>Salary:</strong>
{{ $job->salary_currency }}
{{ $job->salary_min }} - {{ $job->salary_max }}
</div>

<div>
<strong>Applications:</strong>
{{ $job->applications_count }}
</div>

<div>
<strong>Views:</strong>
{{ $job->views_count }}
</div>

</div>

<div>
<h4 class="font-semibold">Description</h4>
<p>{{ $job->job_description }}</p>
</div>

<div>
<h4 class="font-semibold">Required Skills</h4>

@foreach($job->skills as $skill)
<span class="badge bg-indigo-100 text-indigo-700 px-3 py-1 rounded-full">
{{ $skill->name }}
</span>
@endforeach

</div>

</div>

</div>
</div>

@endsection
