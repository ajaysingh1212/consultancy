@extends('admin.layouts.app')

@section('content')

<div class="max-w-6xl mx-auto mt-10">

    <div class="mb-8">
        <h2 class="text-3xl font-bold text-[#7c3aed] flex items-center gap-3">
            🛂 Create Visa Application
        </h2>
        <p class="text-gray-500 mt-1">Fill complete visa processing details carefully.</p>
    </div>

    <form method="POST"
          action="{{ route('admin.visa-applications.store') }}"
          class="bg-white p-10 rounded-3xl shadow-2xl space-y-10">

        @csrf

        {{-- ================= BASIC INFORMATION ================= --}}
        <div>
            <h3 class="text-xl font-semibold text-[#7c3aed] mb-6 border-b pb-2">
                👤 Applicant & Job Information
            </h3>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                <div>
                    <label class="font-medium">Candidate *</label>
                    <select name="candidate_id" required
                            class="w-full border rounded-xl p-3 mt-2">
                        <option value="">Select Candidate</option>
                        @foreach($candidates as $candidate)
                            <option value="{{ $candidate->id }}"
                                {{ old('candidate_id') == $candidate->id ? 'selected' : '' }}>
                                {{ $candidate->full_name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label class="font-medium">Job *</label>
                    <select name="job_id" required
                            class="w-full border rounded-xl p-3 mt-2">
                        <option value="">Select Job</option>
                        @foreach($jobs as $job)
                            <option value="{{ $job->id }}"
                                {{ old('job_id') == $job->id ? 'selected' : '' }}>
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

                <input name="visa_type" required
                       value="{{ old('visa_type') }}"
                       placeholder="Visa Type *"
                       class="border rounded-xl p-3">

                <input name="country" required
                       value="{{ old('country') }}"
                       placeholder="Destination Country *"
                       class="border rounded-xl p-3">

                <input name="embassy_name"
                       value="{{ old('embassy_name') }}"
                       placeholder="Embassy Name"
                       class="border rounded-xl p-3">

                <input name="application_number"
                       value="{{ old('application_number') }}"
                       placeholder="Application Number"
                       class="border rounded-xl p-3">

                <input type="date" name="submission_date"
                       value="{{ old('submission_date') }}"
                       class="border rounded-xl p-3">

                <input type="date" name="appointment_date"
                       value="{{ old('appointment_date') }}"
                       class="border rounded-xl p-3">

                <input type="date" name="visa_issue_date"
                       value="{{ old('visa_issue_date') }}"
                       class="border rounded-xl p-3">

                <input type="date" name="visa_expiry_date"
                       value="{{ old('visa_expiry_date') }}"
                       class="border rounded-xl p-3">

            </div>
        </div>


        {{-- ================= STATUS SECTION ================= --}}
        <div>
            <h3 class="text-xl font-semibold text-[#7c3aed] mb-6 border-b pb-2">
                📊 Processing Status
            </h3>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">

                <select name="medical_status" class="border rounded-xl p-3">
                    <option value="pending">Medical Pending</option>
                    <option value="fit">Medical Fit</option>
                    <option value="unfit">Medical Unfit</option>
                </select>

                <select name="immigration_status" class="border rounded-xl p-3">
                    <option value="pending">Immigration Pending</option>
                    <option value="approved">Immigration Approved</option>
                    <option value="rejected">Immigration Rejected</option>
                </select>

                <select name="visa_status" class="border rounded-xl p-3">
                    <option value="draft">Draft</option>
                    <option value="submitted">Submitted</option>
                    <option value="processing">Processing</option>
                    <option value="approved">Approved</option>
                    <option value="rejected">Rejected</option>
                </select>

            </div>
        </div>


        {{-- ================= STAGE TRACKING ================= --}}
        <div>
            <h3 class="text-xl font-semibold text-[#7c3aed] mb-6 border-b pb-2">
                🕒 Stage Timeline
            </h3>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">

                <input type="date" name="medical_date"
                       value="{{ old('medical_date') }}"
                       placeholder="Medical Date"
                       class="border rounded-xl p-3">

                <input type="date" name="pcc_date"
                       value="{{ old('pcc_date') }}"
                       class="border rounded-xl p-3">

                <input type="date" name="visa_submitted_date"
                       value="{{ old('visa_submitted_date') }}"
                       class="border rounded-xl p-3">

                <input type="date" name="visa_approved_date"
                       value="{{ old('visa_approved_date') }}"
                       class="border rounded-xl p-3">

                <input type="date" name="ticket_issued_date"
                       value="{{ old('ticket_issued_date') }}"
                       class="border rounded-xl p-3">

                <input type="date" name="deployment_date"
                       value="{{ old('deployment_date') }}"
                       class="border rounded-xl p-3">

            </div>
        </div>


        {{-- ================= FINANCIAL SECTION ================= --}}
        <div>
            <h3 class="text-xl font-semibold text-[#7c3aed] mb-6 border-b pb-2">
                💰 Financial Details
            </h3>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                <input type="number" step="0.01" name="visa_fee"
                       value="{{ old('visa_fee') }}"
                       placeholder="Visa Fee"
                       class="border rounded-xl p-3">

                <input type="number" step="0.01" name="service_charge"
                       value="{{ old('service_charge') }}"
                       placeholder="Service Charge"
                       class="border rounded-xl p-3">

            </div>
        </div>


        {{-- ================= REMARKS ================= --}}
        <div>
            <h3 class="text-xl font-semibold text-[#7c3aed] mb-4">
                📝 Remarks
            </h3>

            <textarea name="remarks"
                      rows="4"
                      class="w-full border rounded-xl p-3"
                      placeholder="Additional notes...">{{ old('remarks') }}</textarea>
        </div>


        {{-- ================= SUBMIT ================= --}}
        <div class="text-right">
            <button class="bg-[#7c3aed] hover:bg-[#6d28d9]
                           text-white px-10 py-3 rounded-2xl shadow-lg transition">
                💾 Save Visa Application
            </button>
        </div>

    </form>

</div>

@endsection
<script>
document.addEventListener('DOMContentLoaded', function () {

    const candidateSelect = document.querySelector('select[name="candidate_id"]');
    const jobSelect = document.querySelector('select[name="job_id"]');

    /* ================= CANDIDATE DETAILS ================= */
    if (candidateSelect) {
        candidateSelect.addEventListener('change', function () {

            let id = this.value;
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
                    ).join('') || 'No Skills';

                    let jobs = data.applications?.map(a =>
                        `<li>• ${a.job.job_title}</li>`
                    ).join('') || 'No Applications';

                    let documentStatus = data.documents?.some(doc => doc.is_verified)
                        ? '<span class="text-green-600 font-semibold">Verified</span>'
                        : '<span class="text-red-500 font-semibold">Pending</span>';

                    card.innerHTML = `
                        <h3 class="font-bold text-purple-700 mb-6 text-lg">👤 Candidate Details</h3>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div><p><strong>Email:</strong><br>${data.email ?? '-'}</p></div>
                            <div>
                                <p><strong>KYC Status:</strong><br>
                                ${data.kyc_verified 
                                    ? '<span class="text-green-600 font-semibold">Verified</span>' 
                                    : '<span class="text-red-500 font-semibold">Pending</span>'}
                                </p>
                            </div>
                            <div><p><strong>Mobile:</strong><br>${data.mobile ?? '-'}</p></div>
                            <div>
                                <p><strong>Address Status:</strong><br>
                                ${data.address_verified 
                                    ? '<span class="text-green-600 font-semibold">Verified</span>' 
                                    : '<span class="text-red-500 font-semibold">Pending</span>'}
                                </p>
                            </div>
                            <div><p><strong>KYC Completion:</strong><br>${data.kyc_completion ?? 0}%</p></div>
                            <div><p><strong>Documents Status:</strong><br>${documentStatus}</p></div>
                        </div>

                        <hr class="my-5">

                        <div class="mt-3"><strong>Skills:</strong><br>${skills}</div>

                        <div class="mt-4">
                            <strong>Applied Jobs:</strong>
                            <ul class="ml-4 mt-1">${jobs}</ul>
                        </div>
                    `;

                    candidateSelect.closest('div').appendChild(card);
                });
        });
    }

    /* ================= JOB DETAILS ================= */
    if (jobSelect) {
        jobSelect.addEventListener('change', function () {

            let id = this.value;
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
                            <div><p><strong>Vacancies:</strong><br>${data.vacancies ?? 0}</p></div>
                            <div><p><strong>Selected Candidate Applied?</strong><br>${appliedStatus}</p></div>
                        </div>

                        <hr class="my-6">

                        <h4 class="font-semibold text-purple-700 mb-4">🏢 Employer Details</h4>

                        <!-- Visible -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div><p><strong>Company Name:</strong><br>${data.employer?.company_name ?? '-'}</p></div>
                            <div><p><strong>Company Email:</strong><br>${data.employer?.company_email ?? '-'}</p></div>
                            <div><p><strong>Company Phone:</strong><br>${data.employer?.company_phone ?? '-'}</p></div>
                            <div><p><strong>Industry:</strong><br>${data.employer?.industry ?? '-'}</p></div>
                        </div>

                        <!-- Hidden -->
                        <div id="employerMoreSection" class="hidden mt-6">

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div><p><strong>Alternate Phone:</strong><br>${data.employer?.alternate_phone ?? '-'}</p></div>
                                <div>
                                    <p><strong>Website:</strong><br>
                                    ${data.employer?.website 
                                        ? `<a href="${data.employer.website}" target="_blank" class="text-blue-600 underline">${data.employer.website}</a>` 
                                        : '-'}
                                    </p>
                                </div>
                                <div><p><strong>Company Size:</strong><br>${data.employer?.company_size ?? '-'}</p></div>
                                <div><p><strong>Founded Year:</strong><br>${data.employer?.founded_year ?? '-'}</p></div>
                                <div><p><strong>Registration No:</strong><br>${data.employer?.registration_number ?? '-'}</p></div>
                                <div><p><strong>GST Number:</strong><br>${data.employer?.gst_number ?? '-'}</p></div>
                                <div><p><strong>Tax Number:</strong><br>${data.employer?.tax_number ?? '-'}</p></div>
                                <div>
                                    <p><strong>Verified:</strong><br>
                                    ${data.employer?.is_verified 
                                        ? '<span class="text-green-600 font-semibold">Verified</span>' 
                                        : '<span class="text-red-500 font-semibold">Not Verified</span>'}
                                    </p>
                                </div>
                            </div>

                            <div class="mt-6">
                                <strong>Full Address:</strong>
                                <p class="text-sm text-gray-700 mt-1">
                                    ${data.employer?.address ?? ''},
                                    ${data.employer?.city ?? ''},
                                    ${data.employer?.state ?? ''},
                                    ${data.employer?.country ?? ''},
                                    ${data.employer?.postal_code ?? ''}
                                </p>
                            </div>

                            <hr class="my-6">

                            <h4 class="font-semibold text-purple-700 mb-4">👨‍💼 HR Contact Details</h4>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div><p><strong>HR Name:</strong><br>${data.employer?.contact_person_name ?? '-'}</p></div>
                                <div><p><strong>Designation:</strong><br>${data.employer?.contact_person_designation ?? '-'}</p></div>
                                <div><p><strong>HR Email:</strong><br>${data.employer?.contact_person_email ?? '-'}</p></div>
                                <div><p><strong>HR Phone:</strong><br>${data.employer?.contact_person_phone ?? '-'}</p></div>
                            </div>

                            <hr class="my-6">

                            <div>
                                <strong>Required Skills:</strong>
                                <ul class="ml-4 mt-2">${skills}</ul>
                            </div>

                            <div class="mt-4">
                                <strong>Job Description:</strong>
                                <p class="text-sm text-gray-700 mt-1">
                                    ${data.description ?? 'No description available'}
                                </p>
                            </div>

                        </div>

                        <div class="mt-4">
                            <button type="button" id="toggleEmployerBtn"
                                class="text-purple-600 font-semibold hover:underline">
                                See More ↓
                            </button>
                        </div>
                    `;

                    jobSelect.closest('div').appendChild(card);

                    const toggleBtn = card.querySelector('#toggleEmployerBtn');
                    const moreSection = card.querySelector('#employerMoreSection');

                    toggleBtn.addEventListener('click', function () {
                        moreSection.classList.toggle('hidden');
                        toggleBtn.innerText = moreSection.classList.contains('hidden')
                            ? 'See More ↓'
                            : 'See Less ↑';
                    });

                });
        });
    }

});
</script>
