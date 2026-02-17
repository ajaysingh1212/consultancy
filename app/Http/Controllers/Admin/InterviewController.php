<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Interview;
use App\Models\JobApplication;
use Illuminate\Http\Request;
use Carbon\Carbon;

class InterviewController extends Controller
{
    public function index()
    {
        $interviews = Interview::with('application.job','application.candidate')
            ->latest()
            ->paginate(15);

        return view('admin.interviews.index', compact('interviews'));
    }

    public function create(Request $request)
    {
        $applicationId = $request->application;

        $application = JobApplication::with('job','candidate')
            ->findOrFail($applicationId);

        return view('admin.interviews.create',
            compact('application'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'job_application_id' => 'required',
            'interview_date'     => 'required|date',
            'mode'               => 'required'
        ]);

        // Google calendar link generate
        $start = Carbon::parse($request->interview_date)
            ->format('Ymd\THis');
        $end = Carbon::parse($request->interview_date)
            ->addHour()
            ->format('Ymd\THis');

        $googleLink =
        "https://calendar.google.com/calendar/render?action=TEMPLATE".
        "&text=Interview".
        "&dates={$start}/{$end}";

        Interview::create([
            'job_application_id' => $request->job_application_id,
            'interview_date'     => $request->interview_date,
            'mode'               => $request->mode,
            'location'           => $request->location,
            'google_calendar_link'=> $googleLink,
            'notes'              => $request->notes,
        ]);

        return redirect()
            ->route('admin.interviews.index')
            ->with('success','Interview scheduled successfully');
    }

    public function show(Interview $interview)
    {
        return view('admin.interviews.show',
            compact('interview'));
    }

    public function edit(Interview $interview)
    {
        return view('admin.interviews.edit',
            compact('interview'));
    }

    public function update(Request $request, Interview $interview)
    {
        $interview->update($request->all());

        return back()->with('success','Updated successfully');
    }

    public function destroy(Interview $interview)
    {
        $interview->delete();
        return back()->with('success','Deleted successfully');
    }
}
