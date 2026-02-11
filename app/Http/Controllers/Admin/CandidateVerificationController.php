<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Candidate;
use App\Models\CandidateAddress;
use App\Models\CandidateDocument;
use App\Models\CandidateEducation;
use App\Models\DocumentVerificationHistory;
use Illuminate\Http\Request;
use App\Notifications\DocumentStatusNotification;

class CandidateVerificationController extends Controller
{
    public function index()
    {
        $candidates = Candidate::with(['documents.histories.admin'])->get();
        return view('admin.candidates.verification.index', compact('candidates'));
    }

    public function verify(Request $request, CandidateDocument $document)
    {
        $request->validate([
            'status'  => 'required|in:verified,rejected',
            'remarks' => 'nullable|string'
        ]);

        // Update document
        $document->update([
            'verification_status' => $request->status,
            'remarks'             => $request->remarks,
            'verified_by'         => auth()->id(),
            'verified_at'         => now(),
        ]);

        // Save history
        DocumentVerificationHistory::create([
            'document_id' => $document->id,
            'action_by'   => auth()->id(),
            'status'      => $request->status,
            'remarks'     => $request->remarks,
        ]);

        // Notify candidate
        if(method_exists($document->candidate,'notify')){
            $document->candidate->notify(
                new DocumentStatusNotification($document)
            );
        }

        // Update KYC
        $this->updateKycStatus($document->candidate);

        return back()->with('success','Document status updated');
    }

    private function updateKycStatus(Candidate $candidate)
    {
        if ($candidate->documents()->where('verification_status','rejected')->exists()) {
            $candidate->update(['kyc_status'=>'rejected']);
            return;
        }

        if ($candidate->documents()->where('verification_status','pending')->exists()) {
            $candidate->update(['kyc_status'=>'partial']);
            return;
        }

        $candidate->update(['kyc_status'=>'verified']);
    }
    public function verifyAddress(Request $request, Candidate $candidate)
    {
        foreach($request->addresses as $id => $data){

            $address = $candidate->addresses()->find($id);

            $address->update([
                'verification_status' => $data['status'],
                'remarks' => $data['remarks'] ?? null,
                'verified_by' => auth()->id(),
                'verified_at' => now(),
            ]);
        }

        return back()->with('success','Address verification updated');
    }
    public function verifyEducation(Request $request, Candidate $candidate)
    {
        foreach($request->educations as $id => $data){

            $edu = $candidate->educations()->find($id);

            $edu->update([
                'verification_status' => $data['status'],
                'remarks' => $data['remarks'] ?? null,
                'verified_by' => auth()->id(),
                'verified_at' => now(),
            ]);
        }

        return back()->with('success','Education verification updated');
    }
    public function verifyDocuments(Request $request, Candidate $candidate)
    {
        foreach($request->documents as $id => $data){

            $doc = $candidate->documents()->find($id);

            $doc->update([
                'verification_status' => $data['status'],
                'remarks' => $data['remarks'] ?? null,
                'verified_by' => auth()->id(),
                'verified_at' => now(),
            ]);
        }

        return back()->with('success','Document verification updated');
    }

    public function history($type,$id)
    {
        if($type === 'document'){
            $model = CandidateDocument::with('histories.user')->findOrFail($id);
            $histories = $model->histories()->latest()->get();
        }

        if($type === 'education'){
            $model = CandidateEducation::with('histories.user')->findOrFail($id);
            $histories = $model->histories()->latest()->get();
        }

        if($type === 'address'){
            $model = CandidateAddress::with('histories.user')->findOrFail($id);
            $histories = $model->histories()->latest()->get();
        }

        return view('admin.candidates.history',compact('histories'));
    }

}
