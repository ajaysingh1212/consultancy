@extends('admin.layouts.app')
@section('content')

<style>
.action-btn{
width:38px;
height:38px;
border-radius:50%;
display:inline-flex;
align-items:center;
justify-content:center;
transition:0.3s;
}
.action-btn:hover{
transform:scale(1.08);
}
</style>

<div class="max-w-7xl mx-auto mt-8">

{{-- HEADER --}}
<div class="flex justify-between mb-6">
<h2 class="text-2xl font-bold text-purple-600">
🧠 Candidate Skills
</h2>
</div>

{{-- CARD --}}
<div class="card p-6">

<table class="datatable w-full">

<thead>
<tr>
<th>#</th>
<th>Candidate</th>
<th>Total Skills</th>
<th>Actions</th>
</tr>
</thead>

<tbody>

@foreach($candidates as $candidate)

<tr class="hover:bg-purple-50">

<td>#{{ $candidate->id }}</td>

<td>
<a href="#"
onclick="showProfile({{ $candidate }})"
class="font-semibold text-purple-600">
{{ $candidate->full_name }}
</a>
</td>

<td>
<span class="px-3 py-1 rounded-full text-sm
{{ $candidate->skills->count() > 0 
? 'bg-green-100 text-green-600' 
: 'bg-red-100 text-red-600' }}">
{{ $candidate->skills->count() }} Skills
</span>
</td>

<td class="space-x-1">

<a href="{{ route('admin.candidate-skills.edit',$candidate) }}"
class="action-btn bg-purple-100 text-purple-600"
title="Manage Skills">
⚙
</a>

</td>

</tr>

@endforeach

</tbody>
</table>

</div>
</div>

<script>
function showProfile(candidate){
alert(
"Name: "+candidate.full_name+
"\nEmail: "+candidate.email+
"\nMobile: "+candidate.mobile+
"\nTotal Skills: "+(candidate.skills?.length ?? 0)
);
}
</script>

@endsection