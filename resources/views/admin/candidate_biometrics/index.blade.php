@extends('admin.layouts.app')

@section('content')

<style>

.table-row:hover{
background:#f9fafb;
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

.action-btn{
display:inline-flex;
align-items:center;
gap:4px;
font-size:14px;
font-weight:500;
}

.action-btn svg{
width:16px;
height:16px;
}

</style>

<div class="max-w-7xl mx-auto mt-8">

<div class="flex justify-between items-center mb-6">

<h2 class="text-2xl font-bold text-indigo-600 flex items-center gap-2">
🧬 Candidate Biometrics
</h2>

<a href="{{ route('admin.candidate-biometrics.create') }}"
class="bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2 rounded-xl shadow flex items-center gap-2">

<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
stroke-width="2" stroke="currentColor" class="w-5 h-5">
<path stroke-linecap="round" stroke-linejoin="round"
d="M12 4v16m8-8H4" />
</svg>

Add Biometric

</a>

</div>

<div class="bg-white rounded-2xl shadow p-6 overflow-x-auto">

<table class="datatable w-full text-left">

<thead>

<tr class="border-b text-gray-600">

<th class="py-3">ID</th>
<th>Candidate</th>
<th>Photo Status</th>
<th class="text-center">Actions</th>

</tr>

</thead>

<tbody>

@foreach($biometrics as $bio)

<tr class="border-b table-row">

<td class="py-3 font-semibold text-gray-700">
#{{ $bio->id }}
</td>

<td>

<div class="flex items-center gap-3">

@if($bio->live_photo)
<img src="{{ asset($bio->live_photo) }}"
class="w-10 h-10 rounded-full object-cover border">
@else
<div class="w-10 h-10 bg-gray-200 rounded-full"></div>
@endif

<span class="font-medium">
{{ $bio->candidate->full_name ?? '' }}
</span>

</div>

</td>

<td>

@if($bio->photo_status=='approved')
<span class="status-badge status-approved">
Approved
</span>
@elseif($bio->photo_status=='rejected')
<span class="status-badge status-rejected">
Rejected
</span>
@else
<span class="status-badge status-pending">
Pending
</span>
@endif

</td>

<td class="text-center space-x-4">

{{-- View --}}
<a href="{{ route('admin.candidate-biometrics.show',$bio) }}"
class="action-btn text-blue-600 hover:text-blue-800">

<svg xmlns="http://www.w3.org/2000/svg" fill="none"
viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
<path stroke-linecap="round" stroke-linejoin="round"
d="M2.25 12s3.75-6.75 9.75-6.75S21.75 12 21.75 12
s-3.75 6.75-9.75 6.75S2.25 12 2.25 12z" />
<path stroke-linecap="round" stroke-linejoin="round"
d="M12 15.75A3.75 3.75 0 1 0 12 8.25a3.75 3.75 0 0 0 0 7.5z" />
</svg>

View

</a>

{{-- Edit --}}
<a href="{{ route('admin.candidate-biometrics.edit',$bio) }}"
class="action-btn text-yellow-600 hover:text-yellow-800">

<svg xmlns="http://www.w3.org/2000/svg" fill="none"
viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
<path stroke-linecap="round" stroke-linejoin="round"
d="M16.862 4.487a2.1 2.1 0 1 1 2.97 2.97L7.5 19.79l-4.5 1.5
1.5-4.5L16.862 4.487z" />
</svg>

Edit

</a>

{{-- Delete --}}
<form method="POST"
action="{{ route('admin.candidate-biometrics.destroy',$bio) }}"
class="inline">

@csrf
@method('DELETE')

<button onclick="return confirm('Delete this biometric?')"
class="action-btn text-red-600 hover:text-red-800">

<svg xmlns="http://www.w3.org/2000/svg" fill="none"
viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
<path stroke-linecap="round" stroke-linejoin="round"
d="M6 7h12M9 7V4h6v3m-7 4v6m4-6v6m4-10v12
a2 2 0 0 1-2 2H8a2 2 0 0 1-2-2V7h12z"/>
</svg>

Delete

</button>

</form>

</td>

</tr>

@endforeach

</tbody>

</table>

</div>

</div>

@endsection
