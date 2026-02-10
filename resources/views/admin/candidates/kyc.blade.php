@extends('admin.layouts.app')

@section('content')

<h2 class="text-2xl font-bold mb-6">
    Candidate KYC – {{ $candidate->full_name }}
</h2>

{{-- KYC PROGRESS --}}
<div class="w-full bg-gray-200 rounded h-3">
    <div class="bg-green-600 h-3 rounded"
         style="width: {{ $candidate->kyc_completion }}%">
    </div>
</div>

<p class="text-sm mt-1">
    KYC Completion: {{ $candidate->kyc_completion }}%
</p>

@php
    $presentAddress = $candidate->addresses->where('type','present')->first();
@endphp

<form method="POST"
      action="{{ route('admin.candidates.kyc.store',$candidate) }}"
      class="space-y-8">
@csrf

{{-- BASIC DETAILS --}}
<div class="bg-white p-6 rounded-lg shadow">
    <h3 class="font-semibold text-lg mb-4 border-b pb-2">
        👤 Basic Details
    </h3>

    <div class="grid grid-cols-2 gap-4">
        <input class="border p-2 rounded bg-gray-100"
               value="{{ $candidate->full_name }}" disabled>

        <input class="border p-2 rounded bg-gray-100"
               value="{{ $candidate->mobile }}" disabled>

        <input class="border p-2 rounded bg-gray-100"
               value="{{ $candidate->passport_number }}" disabled>

        <input class="border p-2 rounded bg-gray-100"
               value="{{ $candidate->nationality }}" disabled>
        <input name="father_name"
               class="border p-2 rounded"
               value="{{ $candidate->father_name ?? '' }}"
               placeholder="Enter Father Name" required>
    </div>
</div>

{{-- ADDRESS --}}
<div class="bg-white p-6 rounded-lg shadow">
    <h3 class="font-semibold text-lg mb-4 border-b pb-2">
        🏠 Address Details
    </h3>

    <div class="grid grid-cols-2 gap-4">
        <input name="address"
               class="border p-2 rounded"
               value="{{ $presentAddress->address ?? '' }}"
               placeholder="Full Address">

        <input name="city"
               class="border p-2 rounded"
               value="{{ $presentAddress->city ?? '' }}"
               placeholder="City">

        <input name="state"
               class="border p-2 rounded"
               value="{{ $presentAddress->state ?? '' }}"
               placeholder="State">

        <input name="pincode"
               class="border p-2 rounded"
               value="{{ $presentAddress->pincode ?? '' }}"
               placeholder="Pincode">
    </div>
</div>

{{-- IDENTITY --}}
<div class="bg-white p-6 rounded-lg shadow">
    <h3 class="font-semibold text-lg mb-4 border-b pb-2">
        🪪 Identity Details
    </h3>

    <div class="grid grid-cols-2 gap-4">
        <input name="aadhaar_no"
               class="border p-2 rounded"
               value="{{ $candidate->aadhaar_no ?? '' }}"
               placeholder="Aadhaar Number">

        <input name="pan_no"
               class="border p-2 rounded"
               value="{{ $candidate->pan_no ?? '' }}"
               placeholder="PAN Number">
    </div>
</div>

{{-- BANK --}}
<div class="bg-white p-6 rounded-lg shadow">
    <h3 class="font-semibold text-lg mb-4 border-b pb-2">
        🏦 Bank Details
    </h3>

    <div class="grid grid-cols-2 gap-4">
        <input name="bank_name"
               class="border p-2 rounded"
               value="{{ $candidate->bank_name ?? '' }}"
               placeholder="Bank Name">

        <input name="account_no"
               class="border p-2 rounded"
               value="{{ $candidate->account_no ?? '' }}"
               placeholder="Account Number">

        <input name="ifsc"
               class="border p-2 rounded"
               value="{{ $candidate->ifsc ?? '' }}"
               placeholder="IFSC Code">

    </div>
</div>

{{-- QUALIFICATION TABLE --}}
<div class="bg-white p-6 rounded-lg shadow">
    <div class="flex justify-between items-center mb-4">
        <h3 class="font-semibold text-lg">
            🎓 Qualification Details
        </h3>

        <button type="button"
                onclick="addQualificationRow()"
                class="bg-blue-600 text-white px-3 py-1 rounded text-sm">
            ➕ Add Row
        </button>
    </div>

    <div class="overflow-x-auto">
    <table class="w-full text-sm border">
        <thead class="bg-gray-100">
            <tr>
                <th class="border p-2">Level</th>
                <th class="border p-2">Board / University</th>
                <th class="border p-2">Roll No</th>
                <th class="border p-2">Roll Code</th>
                <th class="border p-2">Passing Year</th>
                <th class="border p-2">Marks (%)</th>
            </tr>
        </thead>

        <tbody id="qualificationTable">

        {{-- IF EDUCATION EXISTS --}}
        @forelse($candidate->educations as $edu)
            <tr>
                <td class="border p-2">
                    <input type="text"
                           name="qualification[level][]"
                           value="{{ ucfirst($edu->level) }}"
                           class="border p-1 rounded w-full">
                </td>
                <td class="border p-2">
                    <input type="text"
                           name="qualification[board][]"
                           value="{{ $edu->board_university }}"
                           class="border p-1 rounded w-full">
                </td>
                <td class="border p-2">
                    <input type="text"
                           name="qualification[roll_no][]"
                           value="{{ $edu->roll_no ?? '' }}"
                           class="border p-1 rounded w-full">
                </td>
                <td class="border p-2">
                    <input type="text"
                           name="qualification[roll_code][]"
                           value="{{ $edu->roll_code ?? '' }}"
                           class="border p-1 rounded w-full">
                </td>
                <td class="border p-2">
                    <input type="text"
                           name="qualification[year][]"
                           value="{{ $edu->passing_year }}"
                           class="border p-1 rounded w-full">
                </td>
                <td class="border p-2">
                    <input type="text"
                           name="qualification[marks][]"
                           value="{{ $edu->marks }}"
                           class="border p-1 rounded w-full">
                </td>
            </tr>
        @empty
            {{-- DEFAULT ROWS --}}
            @foreach(['8th','10th','12th','Graduation'] as $level)
            <tr>
                <td class="border p-2">
                    <input type="text"
                           name="qualification[level][]"
                           value="{{ $level }}"
                           readonly
                           class="border p-1 rounded w-full bg-gray-100">
                </td>
                <td class="border p-2">
                    <input type="text" name="qualification[board][]"
                           class="border p-1 rounded w-full">
                </td>
                <td class="border p-2">
                    <input type="text" name="qualification[roll_no][]"
                           class="border p-1 rounded w-full">
                </td>
                <td class="border p-2">
                    <input type="text" name="qualification[roll_code][]"
                           class="border p-1 rounded w-full">
                </td>
                <td class="border p-2">
                    <input type="text" name="qualification[year][]"
                           class="border p-1 rounded w-full">
                </td>
                <td class="border p-2">
                    <input type="text" name="qualification[marks][]"
                           class="border p-1 rounded w-full">
                </td>
            </tr>
            @endforeach
        @endforelse

        </tbody>
    </table>
    </div>
</div>

{{-- SUBMIT --}}
<div class="flex justify-end">
    <button class="bg-green-600 hover:bg-green-700 text-white px-8 py-2 rounded-lg text-lg">
        ✅ Save KYC
    </button>
</div>

</form>

{{-- JS FOR ADD ROW --}}
<script>
function addQualificationRow(){
    document.getElementById('qualificationTable').insertAdjacentHTML('beforeend', `
        <tr>
            <td class="border p-2">
                <input type="text"
                       name="qualification[level][]"
                       placeholder="Other"
                       class="border p-1 rounded w-full">
            </td>
            <td class="border p-2">
                <input type="text"
                       name="qualification[board][]"
                       class="border p-1 rounded w-full">
            </td>
            <td class="border p-2">
                <input type="text"
                       name="qualification[roll_no][]"
                       class="border p-1 rounded w-full">
            </td>
            <td class="border p-2">
                <input type="text"
                       name="qualification[roll_code][]"
                       class="border p-1 rounded w-full">
            </td>
            <td class="border p-2">
                <input type="text"
                       name="qualification[year][]"
                       class="border p-1 rounded w-full">
            </td>
            <td class="border p-2">
                <input type="text"
                       name="qualification[marks][]"
                       class="border p-1 rounded w-full">
            </td>
        </tr>
    `);
}
</script>

@endsection
