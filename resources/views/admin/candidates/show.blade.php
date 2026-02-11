@extends('admin.layouts.app')

@section('content')

<div class="space-y-8">

{{-- HEADER --}}
<div class="bg-white rounded-xl shadow p-6 border">
    <div class="flex justify-between items-center">
        <div>
            <h2 class="text-2xl font-bold">
                {{ $candidate->full_name }}
            </h2>
            <p class="text-sm text-gray-500">
                Passport: {{ $candidate->passport_number }}
            </p>
        </div>

        <div class="w-64">
            <div class="flex justify-between text-xs mb-1">
                <span>KYC Completion</span>
                <span>{{ $candidate->kyc_completion }}%</span>
            </div>
            <div class="w-full bg-gray-200 rounded-full h-3">
                <div class="bg-green-600 h-3 rounded-full"
                     style="width: {{ $candidate->kyc_completion }}%">
                </div>
            </div>
        </div>
    </div>
</div>


{{-- BASIC INFO --}}
<div class="bg-white rounded-xl shadow p-6 border">
    <h3 class="font-semibold text-lg mb-4">Basic Information</h3>

    <div class="grid md:grid-cols-3 gap-4 text-sm">

        <div><strong>Father Name:</strong> {{ $candidate->father_name }}</div>
        <div><strong>DOB:</strong> {{ $candidate->dob }}</div>
        <div><strong>Gender:</strong> {{ $candidate->gender }}</div>
        <div><strong>Marital Status:</strong> {{ $candidate->marital_status }}</div>
        <div><strong>Mobile:</strong> {{ $candidate->mobile }}</div>
        <div><strong>Email:</strong> {{ $candidate->email }}</div>
        <div><strong>Nationality:</strong> {{ $candidate->nationality }}</div>
        <div><strong>Aadhaar:</strong> {{ $candidate->aadhaar_no }}</div>
        <div><strong>PAN:</strong> {{ $candidate->pan_no }}</div>
        <div><strong>Bank:</strong> {{ $candidate->bank_name }}</div>
        <div><strong>Account:</strong> {{ $candidate->account_no }}</div>
        <div><strong>IFSC:</strong> {{ $candidate->ifsc }}</div>

    </div>
</div>


{{-- ADDRESS SECTION --}}
<div class="bg-white rounded-xl shadow p-6 border">
    <h3 class="font-semibold text-lg mb-4">Address Details</h3>

    <table class="w-full text-sm">
        <thead class="bg-gray-100">
            <tr>
                <th class="p-2 text-left">Type</th>
                <th class="p-2 text-left">Address</th>
                <th class="p-2">Status</th>
                <th class="p-2">Verified At</th>
            </tr>
        </thead>
        <tbody class="divide-y">

        @foreach($candidate->addresses as $address)
        <tr>
            <td class="p-2 capitalize">{{ $address->type }}</td>
            <td class="p-2">{{ $address->full_address }}</td>
            <td class="p-2 text-center">
                <span class="px-2 py-1 rounded text-xs
                    @if($address->verification_status=='verified') bg-green-100 text-green-700
                    @elseif($address->verification_status=='rejected') bg-red-100 text-red-700
                    @else bg-yellow-100 text-yellow-700 @endif">
                    {{ ucfirst($address->verification_status ?? 'pending') }}
                </span>
            </td>
            <td class="p-2 text-center">
                {{ $address->verified_at ?? '-' }}
            </td>
        </tr>
        @endforeach

        </tbody>
    </table>
</div>


{{-- EDUCATION --}}
<div class="bg-white rounded-xl shadow p-6 border">
    <h3 class="font-semibold text-lg mb-4">Education Details</h3>

    <table class="w-full text-sm">
        <thead class="bg-gray-100">
            <tr>
                <th class="p-2">Level</th>
                <th class="p-2">Board</th>
                <th class="p-2">Roll No</th>
                <th class="p-2">Year</th>
                <th class="p-2">Marks</th>
                <th class="p-2">Status</th>
            </tr>
        </thead>

        <tbody class="divide-y">

        @foreach($candidate->educations as $edu)
        <tr>
            <td class="p-2 capitalize">{{ $edu->level }}</td>
            <td class="p-2">{{ $edu->board_university }}</td>
            <td class="p-2">{{ $edu->roll_no }} / {{ $edu->roll_code }}</td>
            <td class="p-2">{{ $edu->passing_year }}</td>
            <td class="p-2">{{ $edu->marks }}</td>
            <td class="p-2 text-center">
                <span class="px-2 py-1 rounded text-xs
                    @if($edu->verification_status=='verified') bg-green-100 text-green-700
                    @elseif($edu->verification_status=='rejected') bg-red-100 text-red-700
                    @else bg-yellow-100 text-yellow-700 @endif">
                    {{ ucfirst($edu->verification_status ?? 'pending') }}
                </span>
            </td>
        </tr>
        @endforeach

        </tbody>
    </table>
</div>


{{-- DOCUMENTS --}}
<div class="bg-white rounded-xl shadow p-6 border">
    <h3 class="font-semibold text-lg mb-4">Document Verification</h3>

    <table class="w-full text-sm">
        <thead class="bg-gray-100">
            <tr>
                <th class="p-2">Document</th>
                <th class="p-2">Status</th>
                <th class="p-2">Remarks</th>
                <th class="p-2">Verified By</th>
                <th class="p-2">Verified At</th>
            </tr>
        </thead>

        <tbody class="divide-y">

        @foreach($candidate->documents as $doc)
        <tr>
            <td class="p-2 capitalize">
                {{ str_replace('_',' ',$doc->document_type) }}
            </td>
            <td class="p-2 text-center">
                <span class="px-2 py-1 rounded text-xs {{ $doc->status_badge_class }}">
                    {{ ucfirst($doc->verification_status) }}
                </span>
            </td>
            <td class="p-2 text-red-600 text-xs">
                {{ $doc->remarks ?? '-' }}
            </td>
            <td class="p-2 text-center">
                {{ $doc->verifier->name ?? '-' }}
            </td>
            <td class="p-2 text-center">
                {{ $doc->verified_at ?? '-' }}
            </td>
        </tr>
        @endforeach

        </tbody>
    </table>
</div>


{{-- FINAL SUMMARY --}}
<div class="bg-white rounded-xl shadow p-6 border">
    <h3 class="font-semibold text-lg mb-4">Verification Summary</h3>

    <table class="w-full text-sm">
        <thead class="bg-gray-100">
            <tr>
                <th class="p-2">Section</th>
                <th class="p-2">Total</th>
                <th class="p-2">Verified</th>
                <th class="p-2">Pending</th>
                <th class="p-2">Rejected</th>
            </tr>
        </thead>

        <tbody class="divide-y">

        <tr>
            <td class="p-2">Documents</td>
            <td class="p-2 text-center">{{ $candidate->documents->count() }}</td>
            <td class="p-2 text-center">{{ $candidate->documents->where('verification_status','verified')->count() }}</td>
            <td class="p-2 text-center">{{ $candidate->documents->where('verification_status','pending')->count() }}</td>
            <td class="p-2 text-center">{{ $candidate->documents->where('verification_status','rejected')->count() }}</td>
        </tr>

        <tr>
            <td class="p-2">Education</td>
            <td class="p-2 text-center">{{ $candidate->educations->count() }}</td>
            <td class="p-2 text-center">{{ $candidate->educations->where('verification_status','verified')->count() }}</td>
            <td class="p-2 text-center">{{ $candidate->educations->where('verification_status','pending')->count() }}</td>
            <td class="p-2 text-center">{{ $candidate->educations->where('verification_status','rejected')->count() }}</td>
        </tr>

        </tbody>
    </table>
</div>

</div>

@endsection
