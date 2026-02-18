<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Candidate;
use App\Models\CandidateBiometric;
use Illuminate\Http\Request;

class CandidateBiometricController extends Controller
{
    public function index()
    {
        $biometrics = CandidateBiometric::with('candidate')->latest()->get();
        return view('admin.candidate_biometrics.index', compact('biometrics'));
    }

    public function create()
    {
        $candidates = Candidate::all();
        return view('admin.candidate_biometrics.create', compact('candidates'));
    }

    public function store(Request $request)
    {
        $data = $request->all();
        CandidateBiometric::create($data);

        return redirect()->route('admin.candidate-biometrics.index')
            ->with('success','Biometric Created Successfully');
    }

    public function show(CandidateBiometric $candidateBiometric)
    {
        return view('admin.candidate_biometrics.show',
            compact('candidateBiometric'));
    }

    public function edit(CandidateBiometric $candidateBiometric)
    {
        $candidates = Candidate::all();
        return view('admin.candidate_biometrics.edit',
            compact('candidateBiometric','candidates'));
    }

    public function update(Request $request, CandidateBiometric $candidateBiometric)
    {
        $candidateBiometric->update($request->all());

        return redirect()->route('admin.candidate-biometrics.index')
            ->with('success','Biometric Updated Successfully');
    }

    public function destroy(CandidateBiometric $candidateBiometric)
    {
        $candidateBiometric->delete();

        return back()->with('success','Biometric Deleted Successfully');
    }
}
