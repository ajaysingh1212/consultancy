@extends('admin.layouts.app')

@section('content')

<div class="max-w-7xl mx-auto mt-8">

<h2 class="text-3xl font-bold text-purple-600 mb-6">
🛠 Manage Skills - {{ $candidate->full_name }}
</h2>

<form method="POST"
action="{{ route('admin.candidate-skills.update',$candidate) }}">
@csrf

<div class="card space-y-8">

{{-- SKILLS GRID --}}
<div class="grid grid-cols-2 gap-6">

@foreach($skills as $skill)

@php
$existing = $candidate->skills->firstWhere('id',$skill->id);
@endphp

<div class="bg-white p-5 rounded-xl shadow-sm border">

    {{-- Checkbox + Skill Name --}}
    <label class="flex items-center gap-3 mb-4 cursor-pointer">
        <input type="checkbox"
        name="skills[{{ $skill->id }}][enabled]"
        class="w-4 h-4 accent-purple-600"
        {{ $existing ? 'checked' : '' }}>
        <span class="font-semibold text-gray-700">
            {{ $skill->name }}
        </span>
    </label>

    {{-- Proficiency + Experience --}}
    <div class="grid grid-cols-2 gap-4">

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

</div>

{{-- ACTION BUTTONS --}}
<div class="flex gap-4 pt-4">

    <a href="{{ route('admin.candidates.index') }}"
       class="px-6 py-3 rounded-xl
              border border-gray-300
              bg-white
              hover:bg-gray-100
              transition">
        Cancel
    </a>

    <button type="submit"
        class="submit-btn">
        Update Skills
    </button>

</div>

</div>
</form>
</div>

<style>
.card{
background:#f8f7ff;
padding:30px;
border-radius:20px;
}
.input-style{
border:1px solid #ddd;
padding:12px;
border-radius:12px;
width:100%;
transition:0.3s;
}
.input-style:focus{
outline:none;
border-color:#8b5cf6;
box-shadow:0 0 0 2px #ede9fe;
}
.submit-btn{
background:#8b5cf6;
color:white;
padding:12px 25px;
border-radius:12px;
transition:0.3s;
}
.submit-btn:hover{
background:#7c3aed;
}
</style>

@endsection