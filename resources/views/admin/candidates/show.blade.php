@extends('admin.layouts.app')

@section('content')

<div class="space-y-8">

{{-- ================= HEADER PROFILE ================= --}}
<div class="bg-white rounded-xl shadow p-8 border">
    <div class="flex gap-8 items-start">

        {{-- PROFILE IMAGE WITH VERIFIED BADGE --}}
        <div class="relative">
            <div class="w-36 h-36 rounded-full overflow-hidden border-4 border-blue-500 shadow-lg">
                <img src="{{ $candidate->documents->where('document_type','passport')->first()
                        ? asset('storage/'.$candidate->documents->where('document_type','passport')->first()->document_file)
                        : asset('images/default-user.png') }}"
                     class="w-full h-full object-cover">
            </div>

            @if($candidate->kyc_status === 'verified')
                <div class="absolute -bottom-2 left-1/2 -translate-x-1/2
                            bg-green-600 text-white text-xs px-3 py-1
                            rounded-full shadow animate-pulse">
                    ✔ VERIFIED
                </div>
            @endif
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
        <div class="flex-1">
            <h2 class="text-2xl font-bold mb-4">{{ $candidate->full_name }}</h2>

            <div class="grid md:grid-cols-3 gap-4 text-sm">
                <div><strong>Father:</strong> {{ $candidate->father_name }}</div>
                <div><strong>DOB:</strong> {{ $candidate->dob }}</div>
                <div><strong>Gender:</strong> {{ $candidate->gender }}</div>
                <div><strong>Mobile:</strong> {{ $candidate->mobile }}</div>
                <div><strong>Email:</strong> {{ $candidate->email }}</div>
                <div><strong>Nationality:</strong> {{ $candidate->nationality }}</div>
                <div><strong>Passport:</strong> {{ $candidate->passport_number }}</div>
                <div><strong>Aadhaar:</strong> {{ $candidate->aadhaar_no }}</div>
                <div><strong>PAN:</strong> {{ $candidate->pan_no }}</div>
                <div><strong>Bank:</strong> {{ $candidate->bank_name }}</div>
                <div><strong>Account:</strong> {{ $candidate->account_no }}</div>
                <div><strong>IFSC:</strong> {{ $candidate->ifsc }}</div>
            </div>
        </div>

    </div>
</div>

{{-- ================= ADDRESS ================= --}}
@include('admin.candidates.partials.section-address')

{{-- ================= EDUCATION ================= --}}
@include('admin.candidates.partials.section-education')

{{-- ================= DOCUMENT ================= --}}
@include('admin.candidates.partials.section-document')

{{-- ================= FINAL SUMMARY ================= --}}
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


{{-- ================= UPDATE MODAL ================= --}}
<div id="updateModal"
     class="fixed inset-0 bg-black bg-opacity-50 hidden items-center justify-center z-50">

    <div class="bg-white w-96 rounded-xl shadow-lg p-6">

        <h3 class="font-semibold text-lg mb-4">Update Status</h3>

        <form method="POST" id="updateForm">
            @csrf

            <select name="status" class="w-full border rounded p-2 mb-3" required>
                <option value="verified">Verified</option>
                <option value="pending">Pending</option>
                <option value="rejected">Rejected</option>
            </select>

            <textarea name="remarks"
                      placeholder="Enter remarks"
                      class="w-full border rounded p-2 mb-4"></textarea>

            <div class="flex justify-end gap-2">
                <button type="button"
                        onclick="closeModal()"
                        class="bg-gray-400 text-white px-3 py-1 rounded">
                    Cancel
                </button>

                <button class="bg-blue-600 text-white px-4 py-1 rounded">
                    Save
                </button>
            </div>
        </form>
    </div>
</div>


{{-- ================= HISTORY SIDEBAR ================= --}}
<div id="historySidebar"
     class="fixed top-0 right-0 w-96 h-full bg-white shadow-2xl
            transform translate-x-full transition-all duration-500 ease-in-out z-50 overflow-y-auto">

    <div class="p-6 border-b flex justify-between items-center bg-gray-50">
        <h3 class="font-semibold text-lg">Verification History</h3>
        <button onclick="closeHistory()" class="text-red-600 text-xl">×</button>
    </div>

    <div id="historyContent" class="p-6 text-sm">
        Loading...
    </div>
</div>

<script>
function openModal(type,id){

    let form = document.getElementById('updateForm');

    if(type === 'address'){
        form.action = `/admin/address/${id}/update-status`;
    }

    if(type === 'education'){
        form.action = `/admin/education/${id}/update-status`;
    }

    if(type === 'document'){
        form.action = `/admin/document/${id}/update-status`;
    }

    document.getElementById('updateModal').classList.remove('hidden');
    document.getElementById('updateModal').classList.add('flex');
}

function closeModal(){
    document.getElementById('updateModal').classList.add('hidden');
    document.getElementById('updateModal').classList.remove('flex');
}

function openHistory(type,id){
    document.getElementById('historySidebar')
        .classList.remove('translate-x-full');

    fetch(`/admin/history/${type}/${id}`)
        .then(res => res.text())
        .then(data => {
            document.getElementById('historyContent').innerHTML = data;
        });
}

function closeHistory(){
    document.getElementById('historySidebar')
        .classList.add('translate-x-full');
}
</script>

@endsection
