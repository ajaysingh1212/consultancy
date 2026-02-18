@extends('admin.layouts.app')
@section('content')

<div class="max-w-4xl mx-auto mt-8">

<h2 class="text-3xl font-bold text-indigo-600 mb-8">
📅 Schedule Interview
</h2>

<div class="bg-white shadow-xl rounded-3xl p-8 space-y-8">

{{-- APPLICATION INFO --}}
<div class="bg-indigo-50 p-5 rounded-xl">
<h3 class="font-semibold text-indigo-700 mb-3">
Application Details
</h3>

<p><strong>Candidate:</strong> {{ $application->candidate->full_name }}</p>
<p><strong>Email:</strong> {{ $application->candidate->email }}</p>
<p><strong>Job:</strong> {{ $application->job->job_title }}</p>
<p><strong>Match %:</strong> {{ $application->skill_match_percentage }}%</p>
</div>

<form method="POST"
action="{{ route('admin.interviews.store') }}">
@csrf

<input type="hidden"
name="job_application_id"
value="{{ $application->id }}">

{{-- DATE & TIME --}}
<div>
<label class="block font-semibold mb-2">
Interview Date & Time
</label>
<input type="datetime-local"
name="interview_date"
class="input-style"
required>
</div>

{{-- MODE --}}
<div>
<label class="block font-semibold mb-2">
Mode
</label>

<select name="mode"
class="input-style"
required>
<option value="online">Online</option>
<option value="offline">Offline</option>
</select>
</div>

{{-- LOCATION --}}
<div>
<label class="block font-semibold mb-2">
Location (if offline)
</label>

<input type="text"
name="location"
class="input-style"
placeholder="Office Address or Meeting Link">
</div>

{{-- NOTES --}}
<div>
<label class="block font-semibold mb-2">
Notes
</label>

<textarea name="notes"
class="input-style"
placeholder="Interview instructions or remarks"></textarea>
</div>

<button type="submit"
class="bg-indigo-600 hover:bg-indigo-700
text-white px-6 py-3 rounded-xl font-semibold shadow-md transition">
🚀 Schedule Interview
</button>

</form>

</div>
</div>

<style>
.input-style{
border:1px solid #e5e7eb;
padding:12px 15px;
border-radius:12px;
width:100%;
transition:0.3s;
}
.input-style:focus{
outline:none;
border-color:#6366f1;
box-shadow:0 0 0 2px #e0e7ff;
}
</style>

@endsection
