@extends('admin.layouts.app')

@section('content')

<div class="max-w-6xl mx-auto mt-10">

    <div class="mb-8">
        <h2 class="text-3xl font-bold text-[#7c3aed] flex items-center gap-3">
            ✏️ Edit Visa Application
        </h2>
        <p class="text-gray-500 mt-1">Update visa processing details carefully.</p>
    </div>

    <form method="POST"
          action="{{ route('admin.visa-applications.update', $visaApplication->id) }}"
          class="bg-white p-10 rounded-3xl shadow-2xl space-y-10">

        @csrf
        @method('PUT')

        {{-- ================= BASIC INFORMATION ================= --}}
        <div>
            <h3 class="text-xl font-semibold text-[#7c3aed] mb-6 border-b pb-2">
                👤 Applicant & Job Information
            </h3>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                <div>
                    <label class="block text-sm font-semibold mb-2">Select Candidate *</label>
                    <select name="candidate_id" required
                            class="w-full border rounded-xl p-3">
                        <option value="">Select Candidate</option>
                        @foreach($candidates as $candidate)
                            <option value="{{ $candidate->id }}"
                                {{ old('candidate_id', $visaApplication->candidate_id) == $candidate->id ? 'selected' : '' }}>
                                {{ $candidate->full_name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label class="block text-sm font-semibold mb-2">Select Job *</label>
                    <select name="job_id" required
                            class="w-full border rounded-xl p-3">
                        <option value="">Select Job</option>
                        @foreach($jobs as $job)
                            <option value="{{ $job->id }}"
                                {{ old('job_id', $visaApplication->job_id) == $job->id ? 'selected' : '' }}>
                                {{ $job->job_title }}
                            </option>
                        @endforeach
                    </select>
                </div>

            </div>
        </div>

        {{-- ================= VISA DETAILS ================= --}}
        <div>
            <h3 class="text-xl font-semibold text-[#7c3aed] mb-6 border-b pb-2">
                📄 Visa Details
            </h3>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                <div>
                    <label class="block text-sm font-semibold mb-2">Visa Type *</label>
                    <input name="visa_type"
                           value="{{ old('visa_type', $visaApplication->visa_type) }}"
                           class="border rounded-xl p-3 w-full">
                </div>

                <div>
                    <label class="block text-sm font-semibold mb-2">Destination Country *</label>
                    <input name="country"
                           value="{{ old('country', $visaApplication->country) }}"
                           class="border rounded-xl p-3 w-full">
                </div>

                <div>
                    <label class="block text-sm font-semibold mb-2">Embassy Name</label>
                    <input name="embassy_name"
                           value="{{ old('embassy_name', $visaApplication->embassy_name) }}"
                           class="border rounded-xl p-3 w-full">
                </div>

                <div>
                    <label class="block text-sm font-semibold mb-2">Application Number</label>
                    <input name="application_number"
                           value="{{ old('application_number', $visaApplication->application_number) }}"
                           class="border rounded-xl p-3 w-full">
                </div>

                <div>
                    <label class="block text-sm font-semibold mb-2">Submission Date</label>
                    <input type="date" name="submission_date"
                           value="{{ old('submission_date', $visaApplication->submission_date) }}"
                           class="border rounded-xl p-3 w-full">
                </div>

                <div>
                    <label class="block text-sm font-semibold mb-2">Appointment Date</label>
                    <input type="date" name="appointment_date"
                           value="{{ old('appointment_date', $visaApplication->appointment_date) }}"
                           class="border rounded-xl p-3 w-full">
                </div>

                <div>
                    <label class="block text-sm font-semibold mb-2">Visa Issue Date</label>
                    <input type="date" name="visa_issue_date"
                           value="{{ old('visa_issue_date', $visaApplication->visa_issue_date) }}"
                           class="border rounded-xl p-3 w-full">
                </div>

                <div>
                    <label class="block text-sm font-semibold mb-2">Visa Expiry Date</label>
                    <input type="date" name="visa_expiry_date"
                           value="{{ old('visa_expiry_date', $visaApplication->visa_expiry_date) }}"
                           class="border rounded-xl p-3 w-full">
                </div>

            </div>
        </div>

        {{-- ================= STATUS SECTION ================= --}}
        <div>
            <h3 class="text-xl font-semibold text-[#7c3aed] mb-6 border-b pb-2">
                📊 Processing Status
            </h3>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">

                <select name="medical_status" class="border rounded-xl p-3">
                    <option value="pending" {{ old('medical_status', $visaApplication->medical_status) == 'pending' ? 'selected' : '' }}>Medical Pending</option>
                    <option value="fit" {{ old('medical_status', $visaApplication->medical_status) == 'fit' ? 'selected' : '' }}>Medical Fit</option>
                    <option value="unfit" {{ old('medical_status', $visaApplication->medical_status) == 'unfit' ? 'selected' : '' }}>Medical Unfit</option>
                </select>

                <select name="immigration_status" class="border rounded-xl p-3">
                    <option value="pending" {{ old('immigration_status', $visaApplication->immigration_status) == 'pending' ? 'selected' : '' }}>Immigration Pending</option>
                    <option value="approved" {{ old('immigration_status', $visaApplication->immigration_status) == 'approved' ? 'selected' : '' }}>Immigration Approved</option>
                    <option value="rejected" {{ old('immigration_status', $visaApplication->immigration_status) == 'rejected' ? 'selected' : '' }}>Immigration Rejected</option>
                </select>

                <select name="visa_status" class="border rounded-xl p-3">
                    <option value="draft" {{ old('visa_status', $visaApplication->visa_status) == 'draft' ? 'selected' : '' }}>Draft</option>
                    <option value="submitted" {{ old('visa_status', $visaApplication->visa_status) == 'submitted' ? 'selected' : '' }}>Submitted</option>
                    <option value="processing" {{ old('visa_status', $visaApplication->visa_status) == 'processing' ? 'selected' : '' }}>Processing</option>
                    <option value="approved" {{ old('visa_status', $visaApplication->visa_status) == 'approved' ? 'selected' : '' }}>Approved</option>
                    <option value="rejected" {{ old('visa_status', $visaApplication->visa_status) == 'rejected' ? 'selected' : '' }}>Rejected</option>
                </select>

            </div>
        </div>

        {{-- ================= FINANCIAL SECTION ================= --}}
        <div>
            <h3 class="text-xl font-semibold text-[#7c3aed] mb-6 border-b pb-2">
                💰 Financial Details
            </h3>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                <div>
                    <label class="block text-sm font-semibold mb-2">Visa Fee</label>
                    <input type="number" step="0.01" name="visa_fee"
                           value="{{ old('visa_fee', $visaApplication->visa_fee) }}"
                           class="border rounded-xl p-3 w-full">
                </div>

                <div>
                    <label class="block text-sm font-semibold mb-2">Service Charge</label>
                    <input type="number" step="0.01" name="service_charge"
                           value="{{ old('service_charge', $visaApplication->service_charge) }}"
                           class="border rounded-xl p-3 w-full">
                </div>

            </div>
        </div>

        {{-- ================= REMARKS ================= --}}
        <div>
            <label class="block text-sm font-semibold mb-2">Remarks</label>
            <textarea name="remarks"
                      rows="4"
                      class="w-full border rounded-xl p-3">{{ old('remarks', $visaApplication->remarks) }}</textarea>
        </div>

        {{-- ================= SUBMIT ================= --}}
        <div class="text-right">
            <button class="bg-[#7c3aed] hover:bg-[#6d28d9]
                           text-white px-10 py-3 rounded-2xl shadow-lg transition">
                💾 Update Visa Application
            </button>
        </div>

    </form>

</div>

{{-- SAME JS AS CREATE BLADE --}}
{{-- @include('admin.visa-applications.partials.dynamic-script') --}}

@endsection
<script>
document.addEventListener('DOMContentLoaded', function () {

    const candidateSelect = document.querySelector('select[name="candidate_id"]');
    const jobSelect = document.querySelector('select[name="job_id"]');

    /* =========================================================
       CANDIDATE DETAILS FUNCTION
    ========================================================== */
    function loadCandidateDetails(id) {

        if (!id) return;

        fetch(`/admin/candidates/${id}/json`)
            .then(res => res.json())
            .then(data => {

                let existing = document.getElementById('candidateCardDynamic');
                if (existing) existing.remove();

                let card = document.createElement('div');
                card.id = 'candidateCardDynamic';
                card.className = 'bg-gray-50 p-6 rounded-2xl shadow mt-6';

                let skills = data.skills?.map(s =>
                    `<span class="px-2 py-1 bg-green-100 text-green-700 rounded text-xs mr-2 mb-1 inline-block">
                        ${s.name} (${s.pivot.experience_years} yrs)
                    </span>`
                ).join('') || 'No Skills Added';

                let jobs = data.applications?.map(a =>
                    `<li>• ${a.job?.job_title ?? '-'}</li>`
                ).join('') || 'No Applications';

                let documentStatus = data.documents?.some(doc => doc.is_verified)
                    ? '<span class="text-green-600 font-semibold">Verified</span>'
                    : '<span class="text-red-500 font-semibold">Pending</span>';

                card.innerHTML = `
                    <h3 class="font-bold text-purple-700 mb-6 text-lg">👤 Candidate Details</h3>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div><p><strong>Email:</strong><br>${data.email ?? '-'}</p></div>
                        <div><p><strong>Mobile:</strong><br>${data.mobile ?? '-'}</p></div>
                        <div><p><strong>KYC Completion:</strong><br>${data.kyc_completion ?? 0}%</p></div>
                        <div><p><strong>Documents Status:</strong><br>${documentStatus}</p></div>
                    </div>

                    <hr class="my-5">

                    <div class="mt-3">
                        <strong>Skills:</strong><br>
                        ${skills}
                    </div>

                    <div class="mt-4">
                        <strong>Applied Jobs:</strong>
                        <ul class="ml-4 mt-1">${jobs}</ul>
                    </div>
                `;

                candidateSelect.closest('div').appendChild(card);
            });
    }


    /* =========================================================
       JOB DETAILS FUNCTION
    ========================================================== */
    function loadJobDetails(id) {

        if (!id) return;

        let selectedCandidateId = candidateSelect?.value ?? null;

        fetch(`/admin/jobs/${id}/json`)
            .then(res => res.json())
            .then(data => {

                let existing = document.getElementById('jobCardDynamic');
                if (existing) existing.remove();

                let card = document.createElement('div');
                card.id = 'jobCardDynamic';
                card.className = 'bg-gray-50 p-6 rounded-2xl shadow mt-6';

                let skills = data.skills?.map(s =>
                    `<li>• ${s.name} ${s.pivot.is_mandatory ? '(Mandatory)' : ''}</li>`
                ).join('') || '<li>No Skills Listed</li>';

                let applied = false;
                if (selectedCandidateId && data.applications) {
                    applied = data.applications.some(a =>
                        a.candidate_id == selectedCandidateId
                    );
                }

                let appliedStatus = applied
                    ? '<span class="text-green-600 font-semibold">Yes, Applied</span>'
                    : '<span class="text-red-500 font-semibold">Not Applied</span>';

                card.innerHTML = `
                    <h3 class="font-bold text-purple-700 mb-6 text-lg">💼 Job & Employer Details</h3>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div><p><strong>Job Title:</strong><br>${data.job_title ?? '-'}</p></div>
                        <div>
                            <p><strong>Status:</strong><br>
                            ${data.is_active
                                ? '<span class="text-green-600 font-semibold">Active</span>'
                                : '<span class="text-red-500 font-semibold">Inactive</span>'}
                            </p>
                        </div>
                        <div><p><strong>Salary:</strong><br>${data.salary_min ?? 0} - ${data.salary_max ?? 0}</p></div>
                        <div><p><strong>Selected Candidate Applied?</strong><br>${appliedStatus}</p></div>
                    </div>

                    <hr class="my-6">

                    <h4 class="font-semibold text-purple-700 mb-4">🏢 Employer Details</h4>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div><p><strong>Company Name:</strong><br>${data.employer?.company_name ?? '-'}</p></div>
                        <div><p><strong>Company Email:</strong><br>${data.employer?.company_email ?? '-'}</p></div>
                        <div><p><strong>Company Phone:</strong><br>${data.employer?.company_phone ?? '-'}</p></div>
                        <div><p><strong>Industry:</strong><br>${data.employer?.industry ?? '-'}</p></div>
                        <div>
                            <p><strong>Verified:</strong><br>
                            ${data.employer?.is_verified
                                ? '<span class="text-green-600 font-semibold">Verified</span>'
                                : '<span class="text-red-500 font-semibold">Not Verified</span>'}
                            </p>
                        </div>
                    </div>

                    <hr class="my-6">

                    <div>
                        <strong>Required Skills:</strong>
                        <ul class="ml-4 mt-2">${skills}</ul>
                    </div>
                `;

                jobSelect.closest('div').appendChild(card);
            });
    }


    /* =========================================================
       EVENT LISTENERS
    ========================================================== */

    if (candidateSelect) {
        candidateSelect.addEventListener('change', function () {
            loadCandidateDetails(this.value);
        });

        // Auto load on Edit page
        if (candidateSelect.value) {
            loadCandidateDetails(candidateSelect.value);
        }
    }

    if (jobSelect) {
        jobSelect.addEventListener('change', function () {
            loadJobDetails(this.value);
        });

        // Auto load on Edit page
        if (jobSelect.value) {
            loadJobDetails(jobSelect.value);
        }
    }

});
</script>
