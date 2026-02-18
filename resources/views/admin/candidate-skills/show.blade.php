@extends('admin.layouts.app')

@section('content')

<div class="max-w-6xl mx-auto mt-8">

<div class="bg-white rounded-3xl shadow-xl">

{{-- HEADER --}}
<div class="bg-gradient-to-r from-purple-500 to-indigo-500
text-white p-8">

<h2 class="text-2xl font-bold">
🧠 Skills Profile
</h2>

<p>{{ $candidate->full_name }}</p>

</div>

<div class="p-8">

@if($candidate->skills->count())

<div class="grid grid-cols-2 gap-6">

@foreach($candidate->skills as $skill)

<div class="bg-[#f8f7ff] border border-[#e9e7ff]
rounded-2xl p-6 shadow-sm">

<h4 class="font-bold text-lg mb-2">
{{ $skill->name }}
</h4>

<p class="text-sm text-gray-600 mb-2">
Category: {{ $skill->category }}
</p>

<div class="flex justify-between items-center">

{{-- Proficiency Badge --}}
@if($skill->pivot->proficiency == 'expert')
<span class="badge bg-green-100 text-green-700">
Expert
</span>
@elseif($skill->pivot->proficiency == 'intermediate')
<span class="badge bg-yellow-100 text-yellow-700">
Intermediate
</span>
@else
<span class="badge bg-gray-100 text-gray-700">
Beginner
</span>
@endif

<span class="text-sm">
{{ $skill->pivot->experience_years }} Years
</span>

</div>

</div>

@endforeach

</div>

@else

<div class="text-center py-12 text-gray-500">
No skills assigned yet.
</div>

@endif

</div>

</div>

</div>

@endsection
