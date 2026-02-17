@extends('admin.layouts.app')
@section('content')

<div class="max-w-4xl mx-auto mt-8">

<h2 class="text-3xl font-bold text-indigo-600 mb-6">
✏ Edit Interview
</h2>

<div class="bg-white shadow-xl rounded-3xl p-8">

<form method="POST"
action="{{ route('admin.interviews.update',$interview) }}">
@csrf
@method('PUT')

<div class="space-y-6">

<div>
<label class="font-semibold block mb-2">
Interview Date
</label>
<input type="datetime-local"
name="interview_date"
value="{{ $interview->interview_date->format('Y-m-d\TH:i') }}"
class="input-style">
</div>

<div>
<label class="font-semibold block mb-2">
Mode
</label>
<select name="mode" class="input-style">
<option value="online"
{{ $interview->mode=='online'?'selected':'' }}>
Online
</option>
<option value="offline"
{{ $interview->mode=='offline'?'selected':'' }}>
Offline
</option>
</select>
</div>

<div>
<label class="font-semibold block mb-2">
Location
</label>
<input type="text"
name="location"
value="{{ $interview->location }}"
class="input-style">
</div>

<div>
<label class="font-semibold block mb-2">
Notes
</label>
<textarea name="notes"
class="input-style">
{{ $interview->notes }}
</textarea>
</div>

<button type="submit"
class="bg-indigo-600 hover:bg-indigo-700
text-white px-6 py-3 rounded-xl font-semibold">
Update Interview
</button>

</div>
</form>

</div>
</div>

<style>
.input-style{
border:1px solid #e5e7eb;
padding:12px 15px;
border-radius:12px;
width:100%;
}
.input-style:focus{
outline:none;
border-color:#6366f1;
box-shadow:0 0 0 2px #e0e7ff;
}
</style>

@endsection
    