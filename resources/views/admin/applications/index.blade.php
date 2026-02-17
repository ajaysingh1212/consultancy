@extends('admin.layouts.app')
@section('content')

<style>
.progress-wrapper{background:#eee;height:20px;border-radius:20px;overflow:hidden;}
.progress-bar{
height:100%;
display:flex;
align-items:center;
justify-content:center;
color:white;
font-size:12px;
font-weight:bold;
transition:1s ease;
}
.action-btn{
width:38px;height:38px;border-radius:50%;
display:inline-flex;align-items:center;justify-content:center;
transition:0.3s;
}
</style>

<div class="max-w-7xl mx-auto mt-8">

<div class="flex justify-between mb-6">
<h2 class="text-2xl font-bold text-purple-600">
📋 Applications
</h2>

<a href="{{ route('admin.applications.create') }}"
class="bg-purple-600 text-white px-5 py-2 rounded-xl">
➕ New
</a>
</div>

<div class="card p-6">

<table class="datatable w-full">

<thead>
<tr>
<th>#</th>
<th>Candidate</th>
<th>Job</th>
<th>Status</th>
<th>Match</th>
<th>Actions</th>
</tr>
</thead>

<tbody>

@foreach($applications as $app)

@php $match = $app->skill_match_percentage ?? 0; @endphp

<tr class="hover:bg-purple-50">

<td>#{{ $app->id }}</td>

<td>
<a href="#"
onclick="showProfile({{ $app->candidate }})"
class="font-semibold text-purple-600">
{{ $app->candidate->full_name }}
</a>
</td>

<td>{{ $app->job->job_title }}</td>

{{-- INLINE STATUS DROPDOWN --}}
<td>
<form action="{{ route('admin.applications.update',$app) }}"
method="POST">
@csrf @method('PUT')

<select name="status"
onchange="this.form.submit()"
class="border rounded px-2 py-1">

@foreach(['applied','shortlisted','interview','offered','rejected','hired'] as $status)
<option value="{{ $status }}"
{{ $app->status==$status?'selected':'' }}>
{{ ucfirst($status) }}
</option>
@endforeach

</select>

</form>
</td>

{{-- MATCH PROGRESS --}}
<td>
<div class="progress-wrapper">
<div class="progress-bar"
style="width:{{ $match }}%;
background:
{{ $match < 40 ? 'red' :
($match < 60 ? 'orange' : 'green') }};">
{{ $match }}%
</div>
</div>
</td>

<td class="space-x-1">

{{-- VIEW --}}
<a href="{{ route('admin.applications.show',$app) }}"
class="action-btn bg-blue-100">👁</a>

{{-- EDIT --}}
<a href="{{ route('admin.applications.edit',$app) }}"
class="action-btn bg-yellow-100">✏</a>

{{-- INTERVIEW --}}
<a href="{{ route('admin.interviews.create',['application'=>$app->id]) }}"
class="action-btn bg-indigo-100">📅</a>

{{-- OFFER LETTER --}}
<a href="{{ route('admin.offer-letters.create',['application'=>$app->id]) }}"
class="action-btn bg-green-100">📄</a>

{{-- RESUME --}}
@if($app->resume)
<a href="{{ asset($app->resume) }}"
class="action-btn bg-gray-200">⬇</a>
@endif

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
"\nKYC Completion: "+candidate.kyc_completion+"%"
);
}
</script>

@endsection
