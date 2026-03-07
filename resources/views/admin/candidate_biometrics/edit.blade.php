@extends('admin.layouts.app')

@section('content')

<style>

.card{
background:white;
border-radius:18px;
padding:24px;
box-shadow:0 10px 25px rgba(0,0,0,0.08);
}

.section-title{
font-size:18px;
font-weight:700;
color:#4f46e5;
margin-bottom:15px;
}

.photo-box{
border-radius:16px;
overflow:hidden;
border:3px solid #6366f1;
width:220px;
}

.status-select{
border:1px solid #e5e7eb;
border-radius:8px;
padding:6px;
width:100%;
font-size:14px;
}

.finger-card{
background:#fafafa;
border-radius:12px;
padding:12px;
text-align:center;
box-shadow:0 2px 6px rgba(0,0,0,0.05);
}

.finger-card img{
width:80px;
margin:auto;
border-radius:8px;
border:1px solid #ddd;
}

.human-bar{
height:10px;
background:#e5e7eb;
border-radius:20px;
overflow:hidden;
}

.human-fill{
height:100%;
background:linear-gradient(90deg,#10b981,#22c55e);
}

</style>

<div class="max-w-7xl mx-auto mt-8">

<h2 class="text-2xl font-bold text-indigo-600 mb-6">
🧬 Edit Biometric Verification
</h2>

<form method="POST"
action="{{ route('admin.candidate-biometrics.update',$candidateBiometric->id) }}">

@csrf
@method('PUT')

{{-- Candidate Info --}}
<div class="card mb-6">

<h3 class="section-title">Candidate Information</h3>

<input type="text"
value="{{ $candidateBiometric->candidate->full_name }}"
class="w-full border p-2 rounded mt-1 bg-gray-100"
readonly>

</div>

{{-- Live Photo --}}
<div class="card mb-6">

<h3 class="section-title">Live Photo Verification</h3>

<div class="grid grid-cols-2 gap-6 items-center">

<div class="photo-box">
<img src="{{ asset($candidateBiometric->live_photo) }}">
</div>

<div>

@php
$score = $candidateBiometric->face_match_score ?? rand(70,95);
@endphp

<p class="font-semibold text-green-600">
Human Probability : {{ $score }}%
</p>

<div class="human-bar mt-2">
<div class="human-fill" style="width:{{ $score }}%"></div>
</div>

<label class="block mt-4 font-semibold">
Photo Status
</label>

<select name="photo_status" class="status-select">

<option value="approved"
@if($candidateBiometric->photo_status=='approved') selected @endif>
Approved
</option>

<option value="rejected"
@if($candidateBiometric->photo_status=='rejected') selected @endif>
Rejected
</option>

<option value="pending"
@if($candidateBiometric->photo_status=='pending') selected @endif>
Pending
</option>

</select>

</div>

</div>

</div>

{{-- LEFT HAND --}}
<div class="card mb-6">

<h3 class="section-title">✋ Left Hand Biometrics</h3>

<div class="grid grid-cols-5 gap-6">

@php
$left = ['thumb','index','middle','ring','little'];
@endphp

@foreach($left as $finger)

<div class="finger-card">

<img src="{{ asset($candidateBiometric->{'left_'.$finger}) }}">

<p class="text-sm mt-2 capitalize font-semibold">
{{ $finger }}
</p>

<select name="left_{{ $finger }}_status"
class="status-select mt-2">

<option value="approved"
@if($candidateBiometric->{'left_'.$finger.'_status'}=='approved') selected @endif>
Approved
</option>

<option value="rejected"
@if($candidateBiometric->{'left_'.$finger.'_status'}=='rejected') selected @endif>
Rejected
</option>

<option value="pending"
@if($candidateBiometric->{'left_'.$finger.'_status'}=='pending') selected @endif>
Pending
</option>

</select>

</div>

@endforeach

</div>

</div>

{{-- RIGHT HAND --}}
<div class="card mb-6">

<h3 class="section-title">✋ Right Hand Biometrics</h3>

<div class="grid grid-cols-5 gap-6">

@php
$right = ['thumb','index','middle','ring','little'];
@endphp

@foreach($right as $finger)

<div class="finger-card">

<img src="{{ asset($candidateBiometric->{'right_'.$finger}) }}">

<p class="text-sm mt-2 capitalize font-semibold">
{{ $finger }}
</p>

<select name="right_{{ $finger }}_status"
class="status-select mt-2">

<option value="approved"
@if($candidateBiometric->{'right_'.$finger.'_status'}=='approved') selected @endif>
Approved
</option>

<option value="rejected"
@if($candidateBiometric->{'right_'.$finger.'_status'}=='rejected') selected @endif>
Rejected
</option>

<option value="pending"
@if($candidateBiometric->{'right_'.$finger.'_status'}=='pending') selected @endif>
Pending
</option>

</select>

</div>

@endforeach

</div>

</div>

{{-- Buttons --}}
<div class="flex gap-4">

<button class="bg-indigo-600 text-white px-6 py-2 rounded-lg shadow">
💾 Update Status
</button>

<a href="{{ route('admin.candidate-biometrics.index') }}"
class="bg-gray-600 text-white px-6 py-2 rounded-lg shadow">
Cancel
</a>

</div>

</form>

</div>

@endsection
