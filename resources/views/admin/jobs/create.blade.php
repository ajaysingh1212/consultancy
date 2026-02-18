@extends('admin.layouts.app')

@section('content')

<div class="max-w-7xl mx-auto mt-8">

<h2 class="text-3xl font-bold text-[#8b5cf6] mb-8">
🚀 Create New Job
</h2>

<form method="POST" action="{{ route('admin.jobs.store') }}">
@csrf

<div class="card space-y-12">

{{-- ================= BASIC INFO ================= --}}
<div>
<h3 class="section-title">📌 Basic Information</h3>

<div class="grid grid-cols-3 gap-6">

<select name="employer_id" class="input-style" required>
<option value="">Select Employer</option>
@foreach($employers as $emp)
<option value="{{ $emp->id }}">
{{ $emp->company_name }}
</option>
@endforeach
</select>

<input type="text" name="job_title"
class="input-style" placeholder="Job Title" required>

<input type="text" name="job_reference"
class="input-style" placeholder="Reference Code">

<select name="job_type" class="input-style">
<option value="Full-time">Full-time</option>
<option value="Part-time">Part-time</option>
<option value="Internship">Internship</option>
</select>

<select name="work_mode" class="input-style">
<option value="onsite">Onsite</option>
<option value="remote">Remote</option>
<option value="hybrid">Hybrid</option>
</select>

<input type="text" name="experience_level"
class="input-style" placeholder="Experience Level">

<input type="number" name="min_experience"
class="input-style" placeholder="Min Experience">

<input type="number" name="max_experience"
class="input-style" placeholder="Max Experience">

<input type="text" name="location"
class="input-style" placeholder="Location">

<input type="text" name="country"
class="input-style" placeholder="Country">

</div>
</div>

{{-- ================= SALARY ================= --}}
<div>
<h3 class="section-title">💰 Salary Details</h3>

<div class="grid grid-cols-3 gap-6">

<input type="number" step="0.01"
name="salary_min" class="input-style"
placeholder="Minimum Salary">

<input type="number" step="0.01"
name="salary_max" class="input-style"
placeholder="Maximum Salary">

<input type="text"
name="salary_currency"
value="INR"
class="input-style">

</div>

<input type="hidden" name="salary_negotiable" value="0">
<label class="mt-3 flex gap-2">
<input type="checkbox" name="salary_negotiable" value="1">
Salary Negotiable
</label>

</div>

{{-- ================= CONTENT ================= --}}
<div>
<h3 class="section-title">📝 Job Content</h3>

<textarea name="job_summary"
class="input-style" placeholder="Job Summary"></textarea>

<textarea name="job_description"
class="input-style" placeholder="Full Job Description"></textarea>

<textarea name="responsibilities"
class="input-style" placeholder="Responsibilities"></textarea>

<textarea name="requirements"
class="input-style" placeholder="Requirements"></textarea>

<textarea name="benefits"
class="input-style" placeholder="Benefits"></textarea>

</div>

{{-- ================= VACANCY ================= --}}
<div>
<h3 class="section-title">📅 Vacancy & Deadline</h3>

<div class="grid grid-cols-2 gap-6">

<input type="number" name="vacancies"
class="input-style" placeholder="Vacancies">

<input type="date"
name="application_deadline"
class="input-style">

</div>
</div>

{{-- ================= BOOST ================= --}}
<div>
<h3 class="section-title">🚀 Boost & Feature</h3>

<div class="grid grid-cols-3 gap-6">

<input type="hidden" name="is_featured" value="0">
<label>
<input type="checkbox" name="is_featured" value="1">
Featured Job
</label>

<input type="hidden" name="is_boosted" value="0">
<label>
<input type="checkbox" name="is_boosted" value="1">
Boost Job
</label>

<input type="datetime-local"
name="boost_expiry"
class="input-style">

</div>
</div>

{{-- ================= STATUS ================= --}}
<div>
<h3 class="section-title">⚙ Status</h3>

<input type="hidden" name="is_active" value="0">
<input type="hidden" name="is_approved" value="0">

<label class="mr-6">
<input type="checkbox" name="is_active" value="1" checked>
Active
</label>

<label>
<input type="checkbox" name="is_approved" value="1">
Approved
</label>

</div>

{{-- ================= STATS (Hidden Default) ================= --}}
<input type="hidden" name="views_count" value="0">
<input type="hidden" name="applications_count" value="0">

{{-- ================= SKILLS ================= --}}
<div>
<h3 class="section-title">🧠 Required Skills</h3>

@foreach($skills as $skill)

<div class="skill-box">

<label class="flex items-center gap-3">
<input type="checkbox"
name="skills[{{ $skill->id }}][enabled]">
<strong>{{ $skill->name }}</strong>
</label>

<div class="grid grid-cols-3 gap-4 mt-3">

<label>
<input type="checkbox"
name="skills[{{ $skill->id }}][is_mandatory]"
value="1">
Mandatory
</label>

<input type="number"
name="skills[{{ $skill->id }}][experience_required]"
class="input-style"
placeholder="Experience (Years)">

<input type="number"
name="skills[{{ $skill->id }}][weight]"
class="input-style"
placeholder="Weight">

</div>

</div>

@endforeach

</div>

<button type="submit" class="submit-btn">
Save Job
</button>

</div>
</form>
</div>

<style>
.card{background:#f8f7ff;border-radius:24px;padding:35px;}
.input-style{border:1px solid #e9e7ff;padding:12px;border-radius:14px;width:100%;}
.section-title{font-size:18px;font-weight:600;color:#8b5cf6;margin-bottom:14px;}
.submit-btn{background:#8b5cf6;color:white;padding:14px 30px;border-radius:14px;}
.submit-btn:hover{background:#7c3aed;}
.skill-box{border:1px solid #e9e7ff;padding:20px;border-radius:16px;margin-bottom:12px;}
</style>

@endsection
