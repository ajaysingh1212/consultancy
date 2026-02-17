<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Job;
use App\Models\Employer;
use App\Models\Skill;
use Illuminate\Http\Request;

class JobController extends Controller
{
    public function index()
    {
        $jobs = Job::with('employer','skills')
            ->latest()
            ->paginate(15);

        return view('admin.jobs.index', compact('jobs'));
    }

    public function create()
    {
        $employers = Employer::active()->get();
        $skills = Skill::active()->get();

        return view('admin.jobs.create',
            compact('employers','skills'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'employer_id' => 'required',
            'job_title'   => 'required',
            'job_type'    => 'required',
            'location'    => 'required',
            'country'     => 'required',
        ]);

        $job = Job::create($request->except('skills'));

        // Attach Skills
        $skillData = [];

        foreach ($request->skills ?? [] as $skillId => $values) {

            if(isset($values['enabled'])) {

                $skillData[$skillId] = [
                    'is_mandatory'        => isset($values['is_mandatory']),
                    'experience_required' => $values['experience_required'] ?? 0,
                    'weight'              => $values['weight'] ?? 1,
                ];
            }
        }

        $job->skills()->sync($skillData);

        return redirect()
            ->route('admin.jobs.index')
            ->with('success','Job created successfully');
    }

    public function show(Job $job)
    {
        $job->load('skills','employer');

        return view('admin.jobs.show', compact('job'));
    }

    public function edit(Job $job)
    {
        $employers = Employer::all();
        $skills = Skill::active()->get();

        $job->load('skills');

        return view('admin.jobs.edit',
            compact('job','employers','skills'));
    }

    public function update(Request $request, Job $job)
    {
        $job->update($request->except('skills'));

        $skillData = [];

        foreach ($request->skills ?? [] as $skillId => $values) {

            if(isset($values['enabled'])) {

                $skillData[$skillId] = [
                    'is_mandatory'        => isset($values['is_mandatory']),
                    'experience_required' => $values['experience_required'] ?? 0,
                    'weight'              => $values['weight'] ?? 1,
                ];
            }
        }

        $job->skills()->sync($skillData);

        return redirect()
            ->route('admin.jobs.index')
            ->with('success','Job updated successfully');
    }

    public function destroy(Job $job)
    {
        $job->delete();

        return back()->with('success','Job deleted');
    }
}
