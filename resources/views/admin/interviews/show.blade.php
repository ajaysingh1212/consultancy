@extends('admin.layouts.app')
@section('content')

<div class="max-w-4xl mx-auto mt-8">

<h2 class="text-3xl font-bold text-indigo-600 mb-6">
📅 Interview Details
</h2>

<div class="bg-white rounded-3xl shadow-xl p-8 space-y-6">

<p><strong>Candidate:</strong>
{{ $interview->application->candidate->full_name }}</p>

<p><strong>Email:</strong>
{{ $interview->application->candidate->email }}</p>

<p><strong>Job:</strong>
{{ $interview->application->job->job_title }}</p>

<p><strong>Date:</strong>
{{ $interview->interview_date->format('d M Y h:i A') }}</p>

<p><strong>Mode:</strong>
{{ ucfirst($interview->mode) }}</p>

<p><strong>Location:</strong>
{{ $interview->location ?? 'N/A' }}</p>

<p><strong>Notes:</strong>
{{ $interview->notes ?? '-' }}</p>

@if($interview->google_calendar_link)
<a href="{{ $interview->google_calendar_link }}"
target="_blank"
class="bg-indigo-600 text-white px-5 py-2 rounded-xl">
📅 Add to Google Calendar
</a>
@endif

</div>
</div>

@endsection
