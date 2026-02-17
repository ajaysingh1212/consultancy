<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\OfferLetter;
use App\Models\JobApplication;
use Illuminate\Http\Request;

class OfferLetterController extends Controller
{
    public function index()
    {
        $offers = OfferLetter::with('application.job','application.candidate')
            ->latest()
            ->paginate(15);

        return view('admin.offer_letters.index', compact('offers'));
    }

    public function create(Request $request)
    {
        $applicationId = $request->application;

        $application = JobApplication::with('job','candidate')
            ->findOrFail($applicationId);

        return view('admin.offer_letters.create',
            compact('application'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'job_application_id' => 'required',
            'offer_title'        => 'required',
            'offered_salary'     => 'required',
            'joining_date'       => 'required|date',
        ]);

        $offer = OfferLetter::create([
            'job_application_id' => $request->job_application_id,
            'offer_title'        => $request->offer_title,
            'offered_salary'     => $request->offered_salary,
            'joining_date'       => $request->joining_date,
            'offer_description'  => $request->offer_description,
        ]);

        // Auto update status to offered
        $offer->application->update([
            'status' => 'offered'
        ]);

        return redirect()
            ->route('admin.offer-letters.index')
            ->with('success','Offer letter created successfully');
    }

    public function show(OfferLetter $offerLetter)
    {
        return view('admin.offer_letters.show',
            compact('offerLetter'));
    }

    public function edit(OfferLetter $offerLetter)
    {
        return view('admin.offer_letters.edit',
            compact('offerLetter'));
    }

    public function update(Request $request, OfferLetter $offerLetter)
    {
        $offerLetter->update($request->all());

        return back()->with('success','Offer updated');
    }

    public function destroy(OfferLetter $offerLetter)
    {
        $offerLetter->delete();

        return back()->with('success','Deleted');
    }
}
