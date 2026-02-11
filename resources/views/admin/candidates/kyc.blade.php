@extends('admin.layouts.app')

@section('content')

<style>
/* ===== Lavender + Ice White Theme ===== */
.bg-lavender {
    background: linear-gradient(135deg,#f6f3ff,#ffffff);
}

.card-soft {
    background:#ffffff;
    border:1px solid #ece9ff;
    border-radius:16px;
    box-shadow:0 8px 25px rgba(140,120,255,0.08);
}

.lavender-text{ color:#6d5dfc; }

.lavender-btn{
    background:linear-gradient(90deg,#8f84ff,#6d5dfc);
    color:#fff;
    font-size:14px;
    padding:6px 14px;
    border-radius:8px;
}

.lavender-btn:hover{ opacity:.9; }

.input-soft{
    border:1px solid #ddd6fe;
    border-radius:8px;
    padding:6px 10px;
    width:100%;
    font-size:13px;
}

.input-soft:focus{
    outline:none;
    border-color:#8b5cf6;
    box-shadow:0 0 0 2px rgba(139,92,246,0.15);
}
</style>

<div class="bg-lavender p-6 rounded-2xl space-y-6">

    <h2 class="text-xl font-bold lavender-text">
        🪪 Candidate KYC – {{ $candidate->full_name }}
    </h2>

    {{-- KYC PROGRESS --}}
    <div>
        <div class="w-full bg-gray-200 rounded h-2">
            <div class="bg-green-500 h-2 rounded"
                 style="width: {{ $candidate->kyc_completion }}%">
            </div>
        </div>
        <p class="text-md mt-1 text-gray-600">
            KYC Completion: {{ $candidate->kyc_completion }}%
        </p>
    </div>

@php
    $presentAddress = $candidate->addresses->where('type','present')->first();
@endphp

<form method="POST"
      action="{{ route('admin.candidates.kyc.store',$candidate) }}"
      class="space-y-6">
@csrf


{{-- ================= BASIC DETAILS ================= --}}
<div class="card-soft p-3">
    <h3 class="font-semibold lavender-text mb-3 text-md">
        👤 Basic Details
    </h3>

    <div class="grid md:grid-cols-3 gap-3 text-md">

        <input class="input-soft bg-gray-100"
               value="{{ $candidate->full_name }}" disabled>

        <input class="input-soft bg-gray-100"
               value="{{ $candidate->mobile }}" disabled>

        <input class="input-soft bg-gray-100"
               value="{{ $candidate->passport_number }}" disabled>

        <input class="input-soft bg-gray-100"
               value="{{ $candidate->nationality }}" disabled>

        <input name="father_name"
               class="input-soft"
               value="{{ $candidate->father_name ?? '' }}"
               placeholder="Father Name"
               required>
    </div>
</div>


{{-- ================= ADDRESS ================= --}}
<div class="card-soft p-3">
    <h3 class="font-semibold lavender-text mb-3 text-md">
        🏠 Address Details
    </h3>

    <div class="grid md:grid-cols-4 gap-3 text-md">

        <input name="address"
               class="input-soft md:col-span-2"
               value="{{ $presentAddress->address ?? '' }}"
               placeholder="Full Address">

        <input name="city"
               class="input-soft"
               value="{{ $presentAddress->city ?? '' }}"
               placeholder="City">

        <input name="state"
               class="input-soft"
               value="{{ $presentAddress->state ?? '' }}"
               placeholder="State">

        <input name="pincode"
               class="input-soft"
               value="{{ $presentAddress->pincode ?? '' }}"
               placeholder="Pincode">
    </div>
</div>


{{-- ================= IDENTITY ================= --}}
<div class="card-soft p-3">
    <h3 class="font-semibold lavender-text mb-3 text-md">
        🪪 Identity Details
    </h3>

    <div class="grid md:grid-cols-2 gap-3 text-md">

        <input name="aadhaar_no"
               class="input-soft"
               value="{{ $candidate->aadhaar_no ?? '' }}"
               placeholder="Aadhaar Number">

        <input name="pan_no"
               class="input-soft"
               value="{{ $candidate->pan_no ?? '' }}"
               placeholder="PAN Number">
    </div>
</div>


{{-- ================= BANK ================= --}}
<div class="card-soft p-3">
    <h3 class="font-semibold lavender-text mb-3 text-md">
        🏦 Bank Details
    </h3>

    <div class="grid md:grid-cols-3 gap-3 text-md">

        <input name="bank_name"
               class="input-soft"
               value="{{ $candidate->bank_name ?? '' }}"
               placeholder="Bank Name">

        <input name="account_no"
               class="input-soft"
               value="{{ $candidate->account_no ?? '' }}"
               placeholder="Account Number">

        <input name="ifsc"
               class="input-soft"
               value="{{ $candidate->ifsc ?? '' }}"
               placeholder="IFSC Code">
    </div>
</div>


{{-- ================= QUALIFICATION ================= --}}
<div class="card-soft p-3">
    <div class="flex justify-between items-center mb-3">
        <h3 class="font-semibold lavender-text text-md">
            🎓 Qualification Details
        </h3>

        <button type="button"
                onclick="addQualificationRow()"
                class="lavender-btn text-md">
            ➕ Add
        </button>
    </div>

    <div class="overflow-x-auto">
    <table class="w-full text-md border rounded">
        <thead class="bg-purple-50">
            <tr>
                <th class="p-2 border">Level</th>
                <th class="p-2 border">Board</th>
                <th class="p-2 border">Roll No</th>
                <th class="p-2 border">Code</th>
                <th class="p-2 border">Year</th>
                <th class="p-2 border">Marks</th>
            </tr>
        </thead>

        <tbody id="qualificationTable">

        @forelse($candidate->educations as $edu)
        <tr>
            <td class="border p-1">
                <input type="text"
                       name="qualification[level][]"
                       value="{{ ucfirst($edu->level) }}"
                       class="input-soft">
            </td>
            <td class="border p-1">
                <input type="text"
                       name="qualification[board][]"
                       value="{{ $edu->board_university }}"
                       class="input-soft">
            </td>
            <td class="border p-1">
                <input type="text"
                       name="qualification[roll_no][]"
                       value="{{ $edu->roll_no }}"
                       class="input-soft">
            </td>
            <td class="border p-1">
                <input type="text"
                       name="qualification[roll_code][]"
                       value="{{ $edu->roll_code }}"
                       class="input-soft">
            </td>
            <td class="border p-1">
                <input type="text"
                       name="qualification[year][]"
                       value="{{ $edu->passing_year }}"
                       class="input-soft">
            </td>
            <td class="border p-1">
                <input type="text"
                       name="qualification[marks][]"
                       value="{{ $edu->marks }}"
                       class="input-soft">
            </td>
        </tr>
        @empty
        @foreach(['8th','10th','12th','Graduation'] as $level)
        <tr>
            <td class="border p-1">
                <input type="text"
                       name="qualification[level][]"
                       value="{{ $level }}"
                       class="input-soft bg-gray-100"
                       readonly>
            </td>
            <td class="border p-1"><input type="text" name="qualification[board][]" class="input-soft"></td>
            <td class="border p-1"><input type="text" name="qualification[roll_no][]" class="input-soft"></td>
            <td class="border p-1"><input type="text" name="qualification[roll_code][]" class="input-soft"></td>
            <td class="border p-1"><input type="text" name="qualification[year][]" class="input-soft"></td>
            <td class="border p-1"><input type="text" name="qualification[marks][]" class="input-soft"></td>
        </tr>
        @endforeach
        @endforelse

        </tbody>
    </table>
    </div>
</div>


{{-- SUBMIT --}}
{{-- SUBMIT + BACK --}}
<div class="flex justify-end gap-3 mt-4">

    <a href="{{ route('admin.candidates.index') }}"
       class="px-5 py-2 rounded-lg border border-purple-300 text-purple-600 text-md hover:bg-purple-50 transition">
        ⬅ Back
    </a>

    <button type="submit"
            class="lavender-btn px-6 py-2 text-md">
        💾 Save KYC
    </button>

</div>
    

</form>

</div>


<script>
function addQualificationRow(){
    document.getElementById('qualificationTable').insertAdjacentHTML('beforeend', `
        <tr>
            <td class="border p-1"><input type="text" name="qualification[level][]" class="input-soft"></td>
            <td class="border p-1"><input type="text" name="qualification[board][]" class="input-soft"></td>
            <td class="border p-1"><input type="text" name="qualification[roll_no][]" class="input-soft"></td>
            <td class="border p-1"><input type="text" name="qualification[roll_code][]" class="input-soft"></td>
            <td class="border p-1"><input type="text" name="qualification[year][]" class="input-soft"></td>
            <td class="border p-1"><input type="text" name="qualification[marks][]" class="input-soft"></td>
        </tr>
    `);
}
</script>

@endsection
