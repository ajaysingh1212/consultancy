<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Candidate;
use App\Models\CandidateBiometric;
use Illuminate\Support\Facades\Storage;
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

    $photoPath = null;

    if($request->live_photo){

    $image = $request->live_photo;

    $image = str_replace('data:image/png;base64,', '', $image);
    $image = str_replace(' ', '+', $image);

    $imageName = 'live_'.time().'.png';

    Storage::disk('public')->put(
    'biometrics/'.$imageName,
    base64_decode($image)
    );

    $photoPath = 'storage/biometrics/'.$imageName;

    }

    CandidateBiometric::create([

    'candidate_id'=>$request->candidate_id,

    'live_photo'=>$photoPath,

    'photo_status'=>'pending',

    'left_thumb'=>null,
    'left_thumb_status'=>'pending',

    'left_index'=>null,
    'left_index_status'=>'pending',

    'left_middle'=>null,
    'left_middle_status'=>'pending',

    'left_ring'=>null,
    'left_ring_status'=>'pending',

    'left_little'=>null,
    'left_little_status'=>'pending',

    'right_thumb'=>null,
    'right_thumb_status'=>'pending',

    'right_index'=>null,
    'right_index_status'=>'pending',

    'right_middle'=>null,
    'right_middle_status'=>'pending',

    'right_ring'=>null,
    'right_ring_status'=>'pending',

    'right_little'=>null,
    'right_little_status'=>'pending',

    ]);

    return redirect()
    ->route('admin.candidate-biometrics.index')
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
