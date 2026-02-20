<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Deployment;
use App\Models\Candidate;
use App\Models\VisaApplication;
use App\Models\Job;
use Illuminate\Http\Request;

class DeploymentController extends Controller
{

    /* =====================================================
        INDEX
    ===================================================== */

    public function index()
    {
        $deployments = Deployment::with([
                'candidate',
                'visaApplication',
                'job'
            ])
            ->latest()
            ->paginate(20);

        return view('admin.deployments.index', compact('deployments'));
    }

    /* =====================================================
        CREATE
    ===================================================== */

    public function create()
    {
        $candidates = Candidate::orderBy('full_name')->get();
        $visaApplications = VisaApplication::with('candidate')->get();
        $jobs = Job::orderBy('title')->get();

        return view('admin.deployments.create', compact(
            'candidates',
            'visaApplications',
            'jobs'
        ));
    }

    /* =====================================================
        STORE
    ===================================================== */

    public function store(Request $request)
    {
        $data = $request->validate([

            'candidate_id'        => 'required|exists:candidates,id',
            'visa_application_id' => 'required|exists:visa_applications,id',
            'job_id'              => 'nullable|exists:jobs,id',

            'flight_number'       => 'nullable|string|max:255',
            'departure_city'      => 'nullable|string|max:255',
            'arrival_city'        => 'nullable|string|max:255',
            'departure_date'      => 'nullable|date',
            'departure_time'      => 'nullable',
            'arrival_date'        => 'nullable|date',
            'arrival_time'        => 'nullable',

            'ticket_number'       => 'nullable|string|max:255',
            'ticket_status'       => 'required|in:pending,booked,issued',

            'employer_name'       => 'nullable|string|max:255',
            'employer_contact'    => 'nullable|string|max:255',
            'accommodation_address'=> 'nullable|string',

            'deployment_status'   => 'required|in:pending,departed,arrived,completed',

            'joined_date'         => 'nullable|date',
            'contract_start_date' => 'nullable|date',
            'contract_end_date'   => 'nullable|date',

            'remarks'             => 'nullable|string',
        ]);

        Deployment::create($data);

        return redirect()
            ->route('admin.deployments.index')
            ->with('success','Deployment created successfully.');
    }

    /* =====================================================
        SHOW
    ===================================================== */

    public function show(Deployment $deployment)
    {
        $deployment->load([
            'candidate',
            'visaApplication',
            'job'
        ]);

        return view('admin.deployments.show', compact('deployment'));
    }

    /* =====================================================
        EDIT
    ===================================================== */

    public function edit(Deployment $deployment)
    {
        $candidates = Candidate::orderBy('full_name')->get();
        $visaApplications = VisaApplication::with('candidate')->get();
        $jobs = Job::orderBy('title')->get();

        return view('admin.deployments.edit', compact(
            'deployment',
            'candidates',
            'visaApplications',
            'jobs'
        ));
    }

    /* =====================================================
        UPDATE
    ===================================================== */

    public function update(Request $request, Deployment $deployment)
    {
        $data = $request->validate([

            'candidate_id'        => 'required|exists:candidates,id',
            'visa_application_id' => 'required|exists:visa_applications,id',
            'job_id'              => 'nullable|exists:jobs,id',

            'flight_number'       => 'nullable|string|max:255',
            'departure_city'      => 'nullable|string|max:255',
            'arrival_city'        => 'nullable|string|max:255',
            'departure_date'      => 'nullable|date',
            'departure_time'      => 'nullable',
            'arrival_date'        => 'nullable|date',
            'arrival_time'        => 'nullable',

            'ticket_number'       => 'nullable|string|max:255',
            'ticket_status'       => 'required|in:pending,booked,issued',

            'employer_name'       => 'nullable|string|max:255',
            'employer_contact'    => 'nullable|string|max:255',
            'accommodation_address'=> 'nullable|string',

            'deployment_status'   => 'required|in:pending,departed,arrived,completed',

            'joined_date'         => 'nullable|date',
            'contract_start_date' => 'nullable|date',
            'contract_end_date'   => 'nullable|date',

            'remarks'             => 'nullable|string',
        ]);

        $deployment->update($data);

        return redirect()
            ->route('admin.deployments.index')
            ->with('success','Deployment updated successfully.');
    }

    /* =====================================================
        DESTROY
    ===================================================== */

    public function destroy(Deployment $deployment)
    {
        $deployment->delete();

        return redirect()
            ->route('admin.deployments.index')
            ->with('success','Deployment deleted successfully.');
    }
}
