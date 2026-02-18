@extends('admin.layouts.app')
@section('content')

<div class="max-w-7xl mx-auto mt-8">

<h2 class="text-3xl font-bold text-purple-600 mb-6">
🚀 Smart Job Application
</h2>

<form method="POST"
action="{{ route('admin.applications.store') }}"
enctype="multipart/form-data">
@csrf

<div class="card space-y-8">

{{-- JOB + CANDIDATE --}}
<div class="grid grid-cols-2 gap-6">

<select id="jobSelect" name="job_id" class="input-style" required>
<option value="">Select Job</option>
@foreach($jobs as $job)
<option value="{{ $job->id }}"
data-skills='@json($job->skills)'>
{{ $job->job_title }}
</option>
@endforeach
</select>

<select id="candidateSelect"
name="candidate_id"
class="input-style" required>
<option value="">Select Candidate</option>
@foreach($candidates as $c)
<option value="{{ $c->id }}"
data-skills='@json($c->skills)'>
{{ $c->full_name }}
</option>
@endforeach
</select>

</div>

{{-- SKILL DISPLAY --}}
<div class="grid grid-cols-2 gap-8">

<div>
<h4 class="font-semibold mb-3">📌 Required Skills</h4>
<ul id="jobSkills" class="skill-list"></ul>
</div>

<div>
<h4 class="font-semibold mb-3">🧑 Candidate Skills</h4>
<ul id="candidateSkills" class="skill-list"></ul>
</div>

</div>

{{-- MATCH RESULT --}}
<div>
<h4 class="font-semibold mb-3">🎯 Skill Match Result</h4>

<div class="progress-wrapper">
<div id="progressBar" class="progress-bar">0%</div>
</div>

<p id="matchMessage" class="mt-3 font-medium"></p>

<input type="hidden"
name="skill_match_percentage"
id="skillMatchInput">

</div>

{{-- OTHER FIELDS --}}
<textarea name="cover_letter"
class="input-style"
placeholder="Cover Letter"></textarea>

<input type="file" name="resume"
class="input-style">

<button class="submit-btn">
Save Application
</button>

</div>
</form>
</div>

<style>
.card{background:#f8f7ff;padding:30px;border-radius:20px;}
.input-style{border:1px solid #ddd;padding:10px;border-radius:12px;width:100%;}
.skill-list li{padding:5px 0;}
.progress-wrapper{background:#eee;height:25px;border-radius:30px;overflow:hidden;}
.progress-bar{
height:100%;
width:0%;
display:flex;
align-items:center;
justify-content:center;
color:white;
font-weight:bold;
transition:1s ease;
}
.submit-btn{background:#8b5cf6;color:white;padding:12px 25px;border-radius:12px;}
</style>

<script>
function calculateMatch(jobSkills, candidateSkills){

let jobIds = jobSkills.map(s => s.id);
let candidateIds = candidateSkills.map(s => s.id);

let matched = jobIds.filter(id => candidateIds.includes(id)).length;
let total = jobIds.length;

let percentage = total>0 ? Math.round((matched/total)*100) : 0;

let bar = document.getElementById('progressBar');
let msg = document.getElementById('matchMessage');
let input = document.getElementById('skillMatchInput');

bar.style.width = percentage + "%";
bar.innerText = percentage + "%";
input.value = percentage;

if(percentage < 40){
bar.style.background="red";
msg.innerText="Low Match ❌ Consider better candidate.";
}
else if(percentage < 60){
bar.style.background="orange";
msg.innerText="Average Match ⚡ Needs review.";
}
else{
bar.style.background="green";
msg.innerText="Strong Match ✅ Highly Recommended!";
}
}

document.getElementById('jobSelect').addEventListener('change', function(){
let jobSkills = JSON.parse(this.selectedOptions[0].dataset.skills || '[]');
let ul = document.getElementById('jobSkills');
ul.innerHTML='';
jobSkills.forEach(s=> ul.innerHTML += `<li>✔ ${s.name}</li>`);
window.selectedJobSkills = jobSkills;
});

document.getElementById('candidateSelect').addEventListener('change', function(){
let candSkills = JSON.parse(this.selectedOptions[0].dataset.skills || '[]');
let ul = document.getElementById('candidateSkills');
ul.innerHTML='';
candSkills.forEach(s=> ul.innerHTML += `<li>✔ ${s.name}</li>`);
window.selectedCandidateSkills = candSkills;

if(window.selectedJobSkills){
calculateMatch(window.selectedJobSkills, candSkills);
}
});
</script>

@endsection
