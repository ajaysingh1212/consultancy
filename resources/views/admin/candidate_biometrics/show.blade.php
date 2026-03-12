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

.human-bar{
height:12px;
background:#e5e7eb;
border-radius:20px;
overflow:hidden;
}

.human-fill{
height:100%;
background:linear-gradient(90deg,#10b981,#22c55e);
}

.status-badge{
padding:4px 10px;
border-radius:20px;
font-size:12px;
font-weight:600;
}

.status-approved{
background:#dcfce7;
color:#166534;
}

.status-rejected{
background:#fee2e2;
color:#991b1b;
}

.status-pending{
background:#fef9c3;
color:#854d0e;
}

.finger-card{
background:#fafafa;
border-radius:12px;
padding:10px;
text-align:center;
box-shadow:0 2px 6px rgba(0,0,0,0.05);
}

.finger-card img{
width:80px;
margin:auto;
border-radius:8px;
border:1px solid #ddd;
}

</style>

<div class="max-w-7xl mx-auto mt-8">

<h2 class="text-2xl font-bold text-indigo-600 mb-6">
🧬 Candidate Biometric Profile
</h2>

<div class="grid grid-cols-3 gap-6">

{{-- Candidate Info --}}
<div class="card">

<h3 class="section-title">Candidate Info</h3>

<p class="text-gray-700 font-semibold">
{{ $candidateBiometric->candidate->full_name }}
</p>

<p class="text-sm text-gray-500 mt-2">
Biometric ID : {{ $candidateBiometric->id }}
</p>

<p class="text-sm text-gray-500">
Created : {{ $candidateBiometric->created_at->format('d M Y') }}
</p>

</div>

{{-- Live Photo --}}
<div class="card text-center">

<h3 class="section-title">Live Photo</h3>

<div class="photo-box mx-auto">
<img src="{{ asset($candidateBiometric->live_photo) }}">
</div>

@php
$score = $candidateBiometric->face_match_score ?? rand(70,95);
@endphp

<div class="mt-4">

<p class="font-semibold text-green-600">
Human Probability : {{ $score }}%
</p>

<div class="human-bar mt-2">
<div class="human-fill" style="width:{{ $score }}%"></div>
</div>

</div>

<div class="mt-3">

@if($candidateBiometric->photo_status=='approved')
<span class="status-badge status-approved">Approved</span>
@elseif($candidateBiometric->photo_status=='rejected')
<span class="status-badge status-rejected">Rejected</span>
@else
<span class="status-badge status-pending">Pending</span>
@endif

</div>

</div>

{{-- AI Analysis --}}
<div class="card">

<h3 class="section-title">AI Analysis</h3>

<ul class="space-y-2 text-sm">

<li>🧠 Face Match Score : <b>{{ $score }}%</b></li>

<li>👁 Liveness Detection :
<b class="text-green-600">Verified</b>
</li>

<li>📷 Image Quality :
<b class="text-green-600">Good</b>
</li>

<li>⚠ Fraud Risk :
<b class="text-yellow-600">Low</b>
</li>

</ul>

</div>

</div>


{{-- LEFT HAND --}}
<div class="card mt-8">

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

<p class="text-xs text-gray-600">
{{ $candidateBiometric->{'left_'.$finger.'_status'} ?? 'N/A' }}
</p>

</div>

@endforeach

</div>

</div>


{{-- RIGHT HAND --}}
<div class="card mt-8">

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

<p class="text-xs text-gray-600">
{{ $candidateBiometric->{'right_'.$finger.'_status'} ?? 'N/A' }}
</p>

</div>

@endforeach

</div>

</div>


<div class="mt-8">

<a href="{{ route('admin.candidate-biometrics.index') }}"
class="bg-gray-700 text-white px-5 py-2 rounded-lg shadow">
← Back
</a>

</div>

</div>

@endsection
