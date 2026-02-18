@extends('admin.layouts.app')
@section('content')

<div class="max-w-7xl mx-auto mt-8">

<div class="flex justify-between items-center mb-6">
<h2 class="text-2xl font-bold text-indigo-600">
📅 Interviews
</h2>
</div>

<div class="bg-white rounded-3xl shadow-lg p-6">

<table class=" datatable w-full text-left">

<thead>
<tr class="border-b text-indigo-600">
<th>#</th>
<th>Candidate</th>
<th>Job</th>
<th>Date</th>
<th>Mode</th>
<th>Calendar</th>
<th>Action</th>
</tr>
</thead>

<tbody>

@foreach($interviews as $interview)

<tr class="border-b hover:bg-indigo-50 transition">

<td>#{{ $interview->id }}</td>

<td class="font-semibold">
{{ $interview->application->candidate->full_name }}
</td>

<td>
{{ $interview->application->job->job_title }}
</td>

<td>
{{ $interview->interview_date->format('d M Y h:i A') }}
</td>

<td>
<span class="px-3 py-1 rounded-full text-sm
{{ $interview->mode=='online' ? 'bg-green-100 text-green-700' : 'bg-blue-100 text-blue-700' }}">
{{ ucfirst($interview->mode) }}
</span>
</td>

<td>
@if($interview->google_calendar_link)
<a href="{{ $interview->google_calendar_link }}"
target="_blank"
class="text-indigo-600">
📅 Add
</a>
@endif
</td>

<td class="space-x-2">

<a href="{{ route('admin.interviews.show',$interview) }}"
class="bg-blue-100 px-3 py-1 rounded-full">
👁
</a>

<a href="{{ route('admin.interviews.edit',$interview) }}"
class="bg-yellow-100 px-3 py-1 rounded-full">
✏
</a>

<form action="{{ route('admin.interviews.destroy',$interview) }}"
method="POST" class="inline">
@csrf
@method('DELETE')
<button class="bg-red-100 px-3 py-1 rounded-full">
🗑
</button>
</form>

</td>

</tr>

@endforeach

</tbody>
</table>

</div>
</div>

@endsection
