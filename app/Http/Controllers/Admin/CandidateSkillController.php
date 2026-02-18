<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Candidate;
use App\Models\Skill;
use Illuminate\Http\Request;

class CandidateSkillController extends Controller
{
    public function index()
    {
        $candidates = Candidate::with('skills')->paginate(15);

        return view('admin.candidate-skills.index',
            compact('candidates'));
    }
    public function create()
    {
        $candidates = Candidate::all();
        $skills = Skill::active()->get();

        return view('admin.candidate-skills.create',
            compact('candidates','skills'));
    }

    public function store(Request $request)
    {
        $candidate = Candidate::findOrFail($request->candidate_id);

        $data = [];

        foreach ($request->skills ?? [] as $skillId => $values) {

            if(isset($values['enabled'])) {

                $data[$skillId] = [
                    'proficiency' => $values['proficiency'],
                    'experience_years' => $values['experience_years'] ?? 0,
                ];
            }
        }

        $candidate->skills()->sync($data);

        return redirect()
            ->route('admin.candidate-skills.index')
            ->with('success','Skills assigned successfully.');
    }

    public function show(Candidate $candidate)
    {
        $candidate->load('skills');

        return view('admin.candidate-skills.show',
            compact('candidate'));
    }

    public function edit(Candidate $candidate)
    {
        $skills = Skill::active()->get();

        return view('admin.candidate-skills.edit',
            compact('candidate','skills'));
    }

    public function update(Request $request, Candidate $candidate)
    {
        $data = [];

        if ($request->skills) {
            foreach ($request->skills as $skillId => $values) {

                $data[$skillId] = [
                    'proficiency' => $values['proficiency'] ?? 'beginner',
                    'experience_years' => $values['experience_years'] ?? 0,
                ];
            }
        }

        $candidate->skills()->sync($data);

        return redirect()
            ->route('admin.candidate-skills.index')
            ->with('success','Candidate skills updated.');
    }
}
