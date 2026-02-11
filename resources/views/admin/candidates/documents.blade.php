@extends('admin.layouts.app')

@section('content')

<h2 class="text-2xl font-bold mb-6">
    Upload Documents – {{ $candidate->full_name }}
</h2>

<form method="POST"
      action="{{ route('admin.candidates.documents.store',$candidate) }}"
      enctype="multipart/form-data"
      class="space-y-8">
@csrf

@php
$fixedDocs = [
 'aadhaar_front','aadhaar_back','pan_front','pan_back',
 'passport','bank_passbook',
 '10th_marksheet','12th_marksheet','graduation_marksheet'
];
@endphp

<div class="grid md:grid-cols-2 gap-6">

@foreach($fixedDocs as $docType)

@php
$existing = $candidate->documents->where('document_type',$docType)->first();
$status = $existing->verification_status ?? null;
@endphp

<div class="bg-white rounded-xl shadow border p-5 space-y-4">

    {{-- TITLE --}}
    <div class="flex justify-between items-center">
        <h3 class="font-semibold capitalize">
            {{ str_replace('_',' ',$docType) }}
        </h3>

        @if($status)
        <span class="px-3 py-1 text-xs rounded-full
            @if($status=='verified') bg-green-100 text-green-700
            @elseif($status=='rejected') bg-red-100 text-red-700
            @else bg-yellow-100 text-yellow-700 @endif">
            {{ ucfirst($status) }}
        </span>
        @endif
    </div>

    {{-- PREVIEW --}}
    @if($existing)
        <div class="border rounded p-3 bg-gray-50 text-sm">
            <a href="{{ asset('storage/'.$existing->document_file) }}"
               target="_blank"
               class="text-blue-600 hover:underline">
                🔍 View Uploaded File
            </a>

            @if($existing->remarks)
            <p class="text-xs text-red-600 mt-2">
                Reason: {{ $existing->remarks }}
            </p>
            @endif
        </div>
    @endif

    {{-- FILE INPUT --}}
    <div>
        @if($status === 'verified')
            <input type="file" disabled
                class="w-full border p-2 rounded bg-gray-100 cursor-not-allowed">
            <p class="text-xs text-green-600 mt-1">
                Verified document cannot be updated
            </p>

        @else
            <input type="file"
                   name="documents[{{ $docType }}]"
                   class="w-full border p-2 rounded
                   @if($status=='rejected') border-red-500 @endif">
        @endif
    </div>

</div>

@endforeach

</div>

{{-- ADD MORE DOCUMENTS --}}
<div class="bg-white p-6 rounded-xl shadow border space-y-4">

    <h3 class="font-semibold text-lg">
        Additional Documents
    </h3>

    <div id="extraDocs" class="space-y-3"></div>

    <button type="button"
            onclick="addDoc()"
            class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">
        ➕ Add More Documents
    </button>

</div>

{{-- SUBMIT --}}
<div class="flex justify-end">
    <button class="px-8 py-3 bg-green-600 text-white rounded-lg shadow hover:bg-green-700">
        Upload Documents
    </button>
</div>

</form>

@endsection

<script>
function addDoc(){
    document.getElementById('extraDocs').insertAdjacentHTML('beforeend',`
        <div class="flex gap-4">
            <input type="text"
                   name="extra_doc_name[]"
                   placeholder="Document Name"
                   class="border p-2 rounded w-1/2">
            <input type="file"
                   name="extra_doc_file[]"
                   class="border p-2 rounded w-1/2">
        </div>
    `);
}
</script>
