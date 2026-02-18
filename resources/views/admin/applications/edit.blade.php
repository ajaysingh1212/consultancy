@extends('admin.layouts.app')

@section('content')

<div class="max-w-6xl mx-auto mt-8">

<h2 class="text-3xl font-bold text-purple-600 mb-6">
✏ Edit Application
</h2>

<form method="POST"
action="{{ route('admin.applications.update',$application) }}"
enctype="multipart/form-data">
@csrf
@method('PUT')

<div class="card space-y-8">

{{-- JOB & CANDIDATE --}}
<div class="grid grid-cols-2 gap-6">

<select name="job_id" class="input-style">
@foreach($jobs as $job)
<option value="{{ $job->id }}"
{{ $application->job_id == $job->id ? 'selected':'' }}>
{{ $job->job_title }}
</option>
@endforeach
</select>

<select name="candidate_id" class="input-style">
@foreach($candidates as $c)
<option value="{{ $c->id }}"
{{ $application->candidate_id == $c->id ? 'selected':'' }}>
{{ $c->full_name }}
</option>
@endforeach
</select>

</div>

{{-- DOCUMENTS --}}
<div class="grid grid-cols-2 gap-6">

<input type="file" name="resume" class="input-style">

<input type="text"
name="portfolio_link"
value="{{ $application->portfolio_link }}"
class="input-style">

<textarea name="cover_letter"
class="input-style">{{ $application->cover_letter }}</textarea>

</div>

{{-- STATUS --}}
<div class="grid grid-cols-2 gap-6">

<select name="status" class="input-style">
@foreach([
'applied','shortlisted','interview','offered','rejected','hired'
] as $status)
<option value="{{ $status }}"
{{ $application->status==$status?'selected':'' }}>
{{ ucfirst($status) }}
</option>
@endforeach
</select>

<input type="number"
name="score"
value="{{ $application->score }}"
class="input-style">

<input type="number"
step="0.01"
name="skill_match_percentage"
value="{{ $application->skill_match_percentage }}"
class="input-style">

</div>

{{-- TIMELINE --}}
<div class="grid grid-cols-2 gap-6">

<input type="datetime-local"
name="applied_at"
value="{{ optional($application->applied_at)->format('Y-m-d\TH:i') }}"
class="input-style">

<input type="datetime-local"
name="shortlisted_at"
value="{{ optional($application->shortlisted_at)->format('Y-m-d\TH:i') }}"
class="input-style">

<input type="datetime-local"
name="rejected_at"
value="{{ optional($application->rejected_at)->format('Y-m-d\TH:i') }}"
class="input-style">

<input type="datetime-local"
name="hired_at"
value="{{ optional($application->hired_at)->format('Y-m-d\TH:i') }}"
class="input-style">

</div>

<button class="submit-btn">
Update Application
</button>

</div>
</form>
</div>

<style>
.card{background:#f8f7ff;padding:30px;border-radius:20px;}
.input-style{border:1px solid #ddd;padding:10px;border-radius:12px;width:100%;}
.submit-btn{background:#8b5cf6;color:white;padding:12px 25px;border-radius:12px;}
.submit-btn:hover{background:#7c3aed;}
</style>

@endsection
