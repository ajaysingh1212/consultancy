<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Candidate;
use App\Models\CandidateDocument;
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
}
