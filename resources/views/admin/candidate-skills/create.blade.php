@extends('admin.layouts.app')

@section('content')

<div class="max-w-6xl mx-auto mt-8">

<h2 class="text-2xl font-bold text-[#8b5cf6] mb-6">
➕ Assign Skills To Candidate
</h2>

<form method="POST"
action="{{ route('admin.candidate-skills.store') }}">
@csrf

<div class="card space-y-8">

{{-- SELECT CANDIDATE --}}
<div>
<label class="block mb-2 font-semibold">Select Candidate</label>

<select name="candidate_id"
class="input-style" required>
<option value="">Choose Candidate</option>
@foreach($candidates as $candidate)
<option value="{{ $candidate->id }}">
{{ $candidate->full_name }}
</option>
@endforeach
</select>
</div>

{{-- SELECT SKILLS --}}
<div>
<h3 class="section-title">Select Skills</h3>

@foreach($skills as $skill)

<div class="border rounded-xl p-4 flex items-center justify-between mb-3">

<label class="flex items-center gap-3">
<input type="checkbox"
name="skills[{{ $skill->id }}][enabled]">
<strong>{{ $skill->name }}</strong>
</label>

<div class="flex gap-4">

<select name="skills[{{ $skill->id }}][proficiency]"
class="input-style">

<option value="beginner">Beginner</option>
<option value="intermediate">Intermediate</option>
<option value="expert">Expert</option>

</select>

<input type="number"
name="skills[{{ $skill->id }}][experience_years]"
class="input-style"
placeholder="Years">

</div>

</div>

@endforeach
</div>

<button type="submit"
class="submit-btn">
Save Skills
</button>

</div>
</form>

</div>

<style>
.card{
background:#f8f7ff;
border:1px solid #e9e7ff;
border-radius:24px;
padding:32px;
box-shadow:0 10px 30px rgba(139,92,246,0.1);
}
.input-style{
border:1px solid #e9e7ff;
background:white;
padding:10px 14px;
border-radius:12px;
width:100%;
}
.section-title{
font-size:18px;
font-weight:600;
color:#8b5cf6;
margin-bottom:16px;
}
.submit-btn{
background:#8b5cf6;
color:white;
padding:12px 28px;
border-radius:14px;
font-weight:600;
}
.submit-btn:hover{
background:#7c3aed;
}
</style>

@endsection
