<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\JobApplication;
use App\Models\Job;
use App\Models\Candidate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class JobApplicationController extends Controller
{
    public function index()
    {
        $applications = JobApplication::with('job','candidate')
            ->latest()
            ->paginate(15);

        return view('admin.applications.index', compact('applications'));
    }

    public function create()
    {
        $jobs = Job::with(['skills','employer'])->active()->get();
        $candidates = Candidate::with([
            'skills',
            'presentAddress',
            'permanentAddress',
            'educations',
            'wallet'
        ])->get();

        return view('admin.applications.create',
            compact('jobs','candidates'));
    }


    public function store(Request $request)
    {
        $request->validate([
            'job_id' => 'required',
            'candidate_id' => 'required',
        ]);

        $application = JobApplication::create([
            'job_id' => $request->job_id,
            'candidate_id' => $request->candidate_id,
            'resume' => $request->resume,
            'cover_letter' => $request->cover_letter,
            'portfolio_link' => $request->portfolio_link,
            'status' => $request->status ?? JobApplication::STATUS_APPLIED,
            'applied_at' => $request->applied_at ?? now(),
            'shortlisted_at' => $request->shortlisted_at,
            'rejected_at' => $request->rejected_at,
            'hired_at' => $request->hired_at,
        ]);

        $application->calculateSkillMatch();

        return redirect()->route('admin.applications.index')
            ->with('success','Application created successfully');
    }

    public function show(JobApplication $application)
    {
        $application->load('job.skills','candidate.skills');
        return view('admin.applications.show', compact('application'));
    }

    public function edit(JobApplication $application)
    {
        $jobs = Job::with('skills')->get();
        $candidates = Candidate::with('skills')->get();

        return view('admin.applications.edit',
            compact('application','jobs','candidates'));
    }

public function update(Request $request, JobApplication $application)
{
    $oldStatus = $application->status;

    $application->update($request->all());

    if($oldStatus !== $application->status){

        Mail::to($application->candidate->email)
            ->send(new \App\Mail\ApplicationStatusChanged($application));
    }

    return back()->with('success','Updated');
}

    public function destroy(JobApplication $application)
    {
        $application->delete();
        return back()->with('success','Application deleted');
    }
    public function leaderboard()
    {
        $ranking = JobApplication::select('candidate_id')
            ->selectRaw('AVG(score) as avg_score')
            ->groupBy('candidate_id')
            ->orderByDesc('avg_score')
            ->with('candidate')
            ->get();

        return view('admin.applications.leaderboard',
            compact('ranking'));
    }
    public function recommendCandidates(Job $job)
    {
        return Candidate::with('skills')
            ->get()
            ->map(function($candidate) use ($job){

                $matched = $job->skills
                    ->pluck('id')
                    ->intersect(
                        $candidate->skills->pluck('id')
                    )->count();

                return [
                    'candidate' => $candidate,
                    'score' => $matched
                ];
            })
            ->sortByDesc('score')
            ->take(10);
    }

}
