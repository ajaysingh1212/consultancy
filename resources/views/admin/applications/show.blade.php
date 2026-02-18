@extends('admin.layouts.app')

@section('content')

<div class="max-w-6xl mx-auto mt-8">

<div class="bg-white rounded-3xl shadow-xl overflow-hidden">

{{-- HEADER --}}
<div class="bg-gradient-to-r from-purple-500 to-indigo-600 text-white p-8">

<h2 class="text-3xl font-bold">
{{ $application->candidate->full_name }}
</h2>

<p>
Applied for: {{ $application->job->job_title }}
</p>

</div>

<div class="p-8 space-y-8">

{{-- MATCH RESULT --}}
<div>
<h4 class="font-semibold mb-3">🎯 Skill Match</h4>

<div class="progress-wrapper">
<div id="progressBar"
class="progress-bar">
{{ $application->skill_match_percentage }}%
</div>
</div>

<p id="matchMessage" class="mt-3 font-medium"></p>
</div>

{{-- STATUS --}}
<div class="grid grid-cols-3 gap-6">

<div>
<strong>Status:</strong>
<span class="badge">
{{ ucfirst($application->status) }}
</span>
</div>

<div>
<strong>Score:</strong>
{{ $application->score }}
</div>

<div>
<strong>Applied At:</strong>
{{ $application->applied_at }}
</div>

</div>

{{-- SKILL COMPARISON --}}
<div class="grid grid-cols-2 gap-8">

<div>
<h4 class="font-semibold mb-3">📌 Required Skills</h4>
@foreach($application->job->skills as $skill)
<div>✔ {{ $skill->name }}</div>
@endforeach
</div>

<div>
<h4 class="font-semibold mb-3">🧑 Candidate Skills</h4>
@foreach($application->candidate->skills as $skill)
<div>✔ {{ $skill->name }}</div>
@endforeach
</div>

</div>

</div>
</div>
</div>

<style>
.progress-wrapper{
background:#eee;
height:30px;
border-radius:30px;
overflow:hidden;
}
.progress-bar{
height:100%;
display:flex;
align-items:center;
justify-content:center;
color:white;
font-weight:bold;
transition:1s ease;
}
.badge{
background:#ede9fe;
padding:5px 10px;
border-radius:12px;
}
</style>

<script>
let percentage = {{ $application->skill_match_percentage ?? 0 }};
let bar = document.getElementById('progressBar');
let msg = document.getElementById('matchMessage');

bar.style.width = percentage + "%";

if(percentage < 40){
bar.style.background="red";
msg.innerText="Low Match ❌ Candidate needs skill improvement.";
}
else if(percentage < 60){
bar.style.background="orange";
msg.innerText="Average Match ⚡ Review recommended.";
}
else{
bar.style.background="green";
msg.innerText="Strong Match ✅ Highly Suitable Candidate!";
}
</script>

@endsection
