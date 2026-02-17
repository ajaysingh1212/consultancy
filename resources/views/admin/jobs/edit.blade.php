@extends('admin.layouts.app')

@section('content')

<div class="max-w-7xl mx-auto mt-8">

<h2 class="text-3xl font-bold text-[#8b5cf6] mb-8">
✏ Edit Job - {{ $job->job_title }}
</h2>

<form method="POST"
action="{{ route('admin.jobs.update',$job) }}">
@csrf
@method('PUT')

<div class="card space-y-12">

{{-- ================= BASIC INFO ================= --}}
<div>
<h3 class="section-title">📌 Basic Information</h3>

<div class="grid grid-cols-3 gap-6">

<select name="employer_id" class="input-style">
@foreach($employers as $emp)
<option value="{{ $emp->id }}"
{{ $job->employer_id==$emp->id?'selected':'' }}>
{{ $emp->company_name }}
</option>
@endforeach
</select>

<input type="text"
name="job_title"
value="{{ $job->job_title }}"
class="input-style">

<input type="text"
name="job_reference"
value="{{ $job->job_reference }}"
class="input-style">

<select name="job_type" class="input-style">
<option value="Full-time" {{ $job->job_type=='Full-time'?'selected':'' }}>Full-time</option>
<option value="Part-time" {{ $job->job_type=='Part-time'?'selected':'' }}>Part-time</option>
<option value="Internship" {{ $job->job_type=='Internship'?'selected':'' }}>Internship</option>
</select>

<select name="work_mode" class="input-style">
<option value="onsite" {{ $job->work_mode=='onsite'?'selected':'' }}>Onsite</option>
<option value="remote" {{ $job->work_mode=='remote'?'selected':'' }}>Remote</option>
<option value="hybrid" {{ $job->work_mode=='hybrid'?'selected':'' }}>Hybrid</option>
</select>

<input type="text"
name="experience_level"
value="{{ $job->experience_level }}"
class="input-style">

<input type="number"
name="min_experience"
value="{{ $job->min_experience }}"
class="input-style">

<input type="number"
name="max_experience"
value="{{ $job->max_experience }}"
class="input-style">

<input type="text"
name="location"
value="{{ $job->location }}"
class="input-style">

<input type="text"
name="country"
value="{{ $job->country }}"
class="input-style">

</div>
</div>

{{-- ================= SALARY ================= --}}
<div>
<h3 class="section-title">💰 Salary</h3>

<div class="grid grid-cols-3 gap-6">

<input type="number" step="0.01"
name="salary_min"
value="{{ $job->salary_min }}"
class="input-style">

<input type="number" step="0.01"
name="salary_max"
value="{{ $job->salary_max }}"
class="input-style">

<input type="text"
name="salary_currency"
value="{{ $job->salary_currency }}"
class="input-style">

</div>

<input type="hidden" name="salary_negotiable" value="0">
<label class="mt-3 flex gap-2">
<input type="checkbox"
name="salary_negotiable"
value="1"
{{ $job->salary_negotiable?'checked':'' }}>
Negotiable
</label>

</div>

{{-- ================= CONTENT ================= --}}
<div>
<h3 class="section-title">📝 Content</h3>

<textarea name="job_summary"
class="input-style">{{ $job->job_summary }}</textarea>

<textarea name="job_description"
class="input-style">{{ $job->job_description }}</textarea>

<textarea name="responsibilities"
class="input-style">{{ $job->responsibilities }}</textarea>

<textarea name="requirements"
class="input-style">{{ $job->requirements }}</textarea>

<textarea name="benefits"
class="input-style">{{ $job->benefits }}</textarea>

</div>

{{-- ================= VACANCY ================= --}}
<div>
<h3 class="section-title">📅 Vacancy & Deadline</h3>

<div class="grid grid-cols-2 gap-6">

<input type="number"
name="vacancies"
value="{{ $job->vacancies }}"
class="input-style">

<input type="date"
name="application_deadline"
value="{{ optional($job->application_deadline)->format('Y-m-d') }}"
class="input-style">

</div>
</div>

{{-- ================= BOOST ================= --}}
<div>
<h3 class="section-title">🚀 Boost & Feature</h3>

<input type="hidden" name="is_featured" value="0">
<label class="mr-6">
<input type="checkbox"
name="is_featured"
value="1"
{{ $job->is_featured?'checked':'' }}>
Featured
</label>

<input type="hidden" name="is_boosted" value="0">
<label class="mr-6">
<input type="checkbox"
name="is_boosted"
value="1"
{{ $job->is_boosted?'checked':'' }}>
Boosted
</label>

<input type="datetime-local"
name="boost_expiry"
value="{{ optional($job->boost_expiry)->format('Y-m-d\TH:i') }}"
class="input-style mt-4">

</div>

{{-- ================= STATUS ================= --}}
<div>
<h3 class="section-title">⚙ Status</h3>

<input type="hidden" name="is_active" value="0">
<label class="mr-6">
<input type="checkbox"
name="is_active"
value="1"
{{ $job->is_active?'checked':'' }}>
Active
</label>

<input type="hidden" name="is_approved" value="0">
<label>
<input type="checkbox"
name="is_approved"
value="1"
{{ $job->is_approved?'checked':'' }}>
Approved
</label>

</div>

{{-- ================= STATS ================= --}}
<div>
<h3 class="section-title">📊 Stats (Readonly)</h3>

<div class="grid grid-cols-2 gap-6">

<input type="text"
value="Views: {{ $job->views_count }}"
class="input-style" readonly>

<input type="text"
value="Applications: {{ $job->applications_count }}"
class="input-style" readonly>

</div>
</div>

{{-- ================= SKILLS ================= --}}
<div>
<h3 class="section-title">🧠 Required Skills</h3>

@foreach($skills as $skill)
@php
$existing = $job->skills->firstWhere('id',$skill->id);
@endphp

<div class="skill-box">

<label class="flex items-center gap-3">
<input type="checkbox"
name="skills[{{ $skill->id }}][enabled]"
{{ $existing?'checked':'' }}>
<strong>{{ $skill->name }}</strong>
</label>

<div class="grid grid-cols-3 gap-4 mt-3">

<label>
<input type="checkbox"
name="skills[{{ $skill->id }}][is_mandatory]"
value="1"
{{ $existing && $existing->pivot->is_mandatory?'checked':'' }}>
Mandatory
</label>

<input type="number"
name="skills[{{ $skill->id }}][experience_required]"
value="{{ $existing->pivot->experience_required ?? '' }}"
class="input-style"
placeholder="Experience">

<input type="number"
name="skills[{{ $skill->id }}][weight]"
value="{{ $existing->pivot->weight ?? '' }}"
class="input-style"
placeholder="Weight">

</div>

</div>
@endforeach

</div>

<button class="submit-btn">
Update Job
</button>

</div>
</form>
</div>

<style>
.card{background:#f8f7ff;border-radius:24px;padding:35px;}
.input-style{border:1px solid #e9e7ff;padding:12px;border-radius:14px;width:100%;}
.section-title{font-weight:600;color:#8b5cf6;margin-bottom:14px;}
.skill-box{border:1px solid #e9e7ff;padding:20px;border-radius:16px;margin-bottom:12px;}
.submit-btn{background:#8b5cf6;color:white;padding:14px 28px;border-radius:14px;}
.submit-btn:hover{background:#7c3aed;}
</style>

@endsection
