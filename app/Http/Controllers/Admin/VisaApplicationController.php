<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Candidate;
use App\Models\Job;
use App\Models\VisaApplication;
use Illuminate\Http\Request;

class VisaApplicationController extends Controller
{
    public function index()
    {
        $visaApplications = VisaApplication::with(['candidate','job'])
            ->latest()
            ->paginate(20);

        return view('admin.visa-applications.index', compact('visaApplications'));
    }

    /* =====================================================
        CREATE
    ===================================================== */

    public function create()
    {
        $candidates = Candidate::orderBy('full_name')->get();
       $jobs = Job::orderBy('job_title')->get();

        return view('admin.visa-applications.create', compact('candidates','jobs'));
    }

    /* =====================================================
        STORE
    ===================================================== */

    public function store(Request $request)
    {
        $data = $request->validate([

            'candidate_id'      => 'required|exists:candidates,id',
            'job_id'            => 'nullable|exists:jobs,id',

            'visa_type'         => 'required|string|max:255',
            'country'           => 'required|string|max:255',
            'embassy_name'      => 'nullable|string|max:255',
            'application_number'=> 'nullable|string|max:255',

            'submission_date'   => 'nullable|date',
            'appointment_date'  => 'nullable|date',
            'visa_issue_date'   => 'nullable|date',
            'visa_expiry_date'  => 'nullable|date',

            'medical_status'    => 'required|in:pending,fit,unfit',
            'immigration_status'=> 'required|in:pending,approved,rejected',
            'visa_status'       => 'required|in:draft,submitted,processing,approved,rejected',

            'visa_fee'          => 'nullable|numeric',
            'service_charge'    => 'nullable|numeric',

            'remarks'           => 'nullable|string',
        ]);

        VisaApplication::create($data);

        return redirect()
            ->route('admin.visa-applications.index')
            ->with('success','Visa Application created successfully.');
    }

    /* =====================================================
        SHOW
    ===================================================== */

    public function show(VisaApplication $visaApplication)
    {
        $visaApplication->load(['candidate','job','documents','deployment']);

        return view('admin.visa-applications.show', compact('visaApplication'));
    }

    /* =====================================================
        EDIT
    ===================================================== */

    public function edit(VisaApplication $visaApplication)
    {
        $candidates = Candidate::orderBy('full_name')->get();
        $jobs       = Job::orderBy('title')->get();

        return view('admin.visa-applications.edit', compact('visaApplication','candidates','jobs'));
    }

    /* =====================================================
        UPDATE
    ===================================================== */

    public function update(Request $request, VisaApplication $visaApplication)
    {
        $data = $request->validate([

            'candidate_id'      => 'required|exists:candidates,id',
            'job_id'            => 'nullable|exists:jobs,id',

            'visa_type'         => 'required|string|max:255',
            'country'           => 'required|string|max:255',
            'embassy_name'      => 'nullable|string|max:255',
            'application_number'=> 'nullable|string|max:255',

            'submission_date'   => 'nullable|date',
            'appointment_date'  => 'nullable|date',
            'visa_issue_date'   => 'nullable|date',
            'visa_expiry_date'  => 'nullable|date',

            'medical_status'    => 'required|in:pending,fit,unfit',
            'immigration_status'=> 'required|in:pending,approved,rejected',
            'visa_status'       => 'required|in:draft,submitted,processing,approved,rejected',

            'visa_fee'          => 'nullable|numeric',
            'service_charge'    => 'nullable|numeric',

            'remarks'           => 'nullable|string',
        ]);

        $visaApplication->update($data);

        return redirect()
            ->route('admin.visa-applications.index')
            ->with('success','Visa Application updated successfully.');
    }

    /* =====================================================
        DESTROY
    ===================================================== */

    public function destroy(VisaApplication $visaApplication)
    {
        $visaApplication->delete();

        return redirect()
            ->route('admin.visa-applications.index')
            ->with('success','Visa Application deleted successfully.');
    }
}
