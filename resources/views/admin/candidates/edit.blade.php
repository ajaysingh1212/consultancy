@extends('admin.layouts.app')

@section('content')
<h2 class="text-xl font-bold mb-4">
    Edit Candidate – {{ $candidate->full_name }}
</h2>

@if($candidate->kyc_status === 'verified')
<div class="bg-red-100 text-red-700 p-3 rounded mb-4">
    Candidate is verified. Editing disabled.
</div>
@endif

<form method="POST"
      action="{{ route('admin.candidates.update',$candidate) }}">
@csrf @method('PUT')

<fieldset {{ $candidate->kyc_status === 'verified' ? 'disabled' : '' }}>

{{-- BASIC --}}
<div class="bg-white p-4 rounded shadow mb-4">
    <h3 class="font-semibold mb-2">Basic Details</h3>
    <input name="full_name" value="{{ $candidate->full_name }}"
           class="border p-2 w-full">
</div>

{{-- ADDRESS --}}
<div class="bg-white p-4 rounded shadow mb-4">
    <h3 class="font-semibold mb-2">Addresses</h3>
    @foreach($candidate->addresses as $addr)
        <p class="text-sm">{{ $addr->full_address }}</p>
    @endforeach
</div>

{{-- EDUCATION --}}
<div class="bg-white p-4 rounded shadow mb-4">
    <h3 class="font-semibold mb-2">Education</h3>
    @foreach($candidate->educations as $edu)
        <p>{{ $edu->level }} – {{ $edu->board_university }}</p>
    @endforeach
</div>

{{-- DOCUMENTS --}}
<div class="bg-white p-4 rounded shadow mb-4">
    <h3 class="font-semibold mb-2">Documents</h3>
    @foreach($candidate->documents as $doc)
        <p>
            {{ $doc->document_type }}
            <span class="{{ $doc->status_badge_class }}">
                {{ $doc->verification_status }}
            </span>
        </p>
    @endforeach
</div>

<button class="bg-blue-600 text-white px-4 py-2 rounded">
    Update Candidate
</button>

</fieldset>
</form>
@endsection
