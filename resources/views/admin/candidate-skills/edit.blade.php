@extends('admin.layouts.app')

@section('content')

<div class="max-w-6xl mx-auto mt-8">

<h2 class="text-2xl font-bold text-[#8b5cf6] mb-6">
⚙ Manage Skills - {{ $candidate->full_name }}
</h2>

<form method="POST"
action="{{ route('admin.candidate-skills.update',$candidate) }}">
@csrf

<div class="card space-y-6">

@foreach($skills as $skill)

@php
$existing = $candidate->skills->firstWhere('id',$skill->id);
@endphp

<div class="border rounded-xl p-4 flex items-center justify-between">

<div>
<label class="flex items-center gap-3">
<input type="checkbox"
name="skills[{{ $skill->id }}][enabled]"
{{ $existing ? 'checked' : '' }}>
<strong>{{ $skill->name }}</strong>
</label>
</div>

<div class="flex gap-4">

<select name="skills[{{ $skill->id }}][proficiency]"
class="input-style">

<option value="beginner"
{{ $existing && $existing->pivot->proficiency=='beginner'?'selected':'' }}>
Beginner</option>

<option value="intermediate"
{{ $existing && $existing->pivot->proficiency=='intermediate'?'selected':'' }}>
Intermediate</option>

<option value="expert"
{{ $existing && $existing->pivot->proficiency=='expert'?'selected':'' }}>
Expert</option>

</select>

<input type="number"
name="skills[{{ $skill->id }}][experience_years]"
value="{{ $existing->pivot->experience_years ?? 0 }}"
class="input-style"
placeholder="Years">

</div>

</div>

@endforeach

<button class="submit-btn">
Update Skills
</button>

</div>
</form>

</div>

@endsection
