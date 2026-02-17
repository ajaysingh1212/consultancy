@extends('admin.layouts.app')
@section('content')

<div class="max-w-4xl mx-auto mt-8">

<h2 class="text-3xl font-bold text-green-600 mb-8">
📄 Create Offer Letter
</h2>

<div class="bg-white shadow-xl rounded-3xl p-8 space-y-8">

{{-- APPLICATION INFO --}}
<div class="bg-green-50 p-5 rounded-xl">
<h3 class="font-semibold text-green-700 mb-3">
Application Details
</h3>

<p><strong>Candidate:</strong> {{ $application->candidate->full_name }}</p>
<p><strong>Email:</strong> {{ $application->candidate->email }}</p>
<p><strong>Job:</strong> {{ $application->job->job_title }}</p>
<p><strong>Current Match:</strong> {{ $application->skill_match_percentage }}%</p>
</div>

<form method="POST"
action="{{ route('admin.offer-letters.store') }}">
@csrf

<input type="hidden"
name="job_application_id"
value="{{ $application->id }}">

<div>
<label class="block font-semibold mb-2">
Offer Title
</label>
<input type="text"
name="offer_title"
class="input-style"
placeholder="Senior Laravel Developer Offer"
required>
</div>

<div>
<label class="block font-semibold mb-2">
Offered Salary
</label>
<input type="number"
step="0.01"
name="offered_salary"
class="input-style"
required>
</div>

<div>
<label class="block font-semibold mb-2">
Joining Date
</label>
<input type="date"
name="joining_date"
class="input-style"
required>
</div>

<div>
<label class="block font-semibold mb-2">
Offer Description
</label>
<textarea name="offer_description"
class="input-style"
placeholder="Offer terms and conditions"></textarea>
</div>

<button type="submit"
class="bg-green-600 hover:bg-green-700
text-white px-6 py-3 rounded-xl font-semibold shadow-md transition">
🚀 Send Offer
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
border-color:#16a34a;
box-shadow:0 0 0 2px #dcfce7;
}
</style>

@endsection
