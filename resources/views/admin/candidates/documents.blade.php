@extends('admin.layouts.app')

@section('content')
<h2 class="text-xl font-bold mb-4">
    Upload Documents – {{ $candidate->full_name }}
</h2>

<form method="POST"
      action="{{ route('admin.candidates.documents.store',$candidate) }}"
      enctype="multipart/form-data"
      class="space-y-4 bg-white p-6 rounded shadow">
@csrf

@php
$fixedDocs = [
 'aadhaar_front','aadhaar_back','pan_front','pan_back',
 'passport','bank_passbook',
 '10th_marksheet','12th_marksheet','graduation_marksheet'
];
@endphp

{{-- FIXED DOCUMENTS --}}
@foreach($fixedDocs as $doc)
<div class="flex gap-4 items-center">
    <label class="w-48 capitalize">{{ str_replace('_',' ',$doc) }}</label>
    <input type="file" name="documents[{{ $doc }}]" class="border p-2">
</div>

@endforeach

{{-- ADD MORE --}}
<div id="extraDocs"></div>

<button type="button"
        onclick="addDoc()"
        class="bg-blue-600 text-white px-3 py-1 rounded">
    ➕ Add More Documents
</button>

<button class="bg-green-600 text-white px-6 py-2 rounded mt-4">
    Upload Documents
</button>

<script>
function openReject(id){
    document.getElementById('rejectModal'+id).classList.remove('hidden')
}
function closeReject(id){
    document.getElementById('rejectModal'+id).classList.add('hidden')
}
</script>

</form>

<script>
function addDoc(){
    document.getElementById('extraDocs').insertAdjacentHTML('beforeend',`
        <div class="flex gap-4 mt-2">
            <input type="text" name="extra_doc_name[]"
                   placeholder="Document Name"
                   class="border p-2 w-48">
            <input type="file" name="extra_doc_file[]"
                   class="border p-2">
        </div>
    `);
}
</script>
@endsection
