<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Candidate;
use App\Models\CandidateDocument;
use Illuminate\Http\Request;
use App\Notifications\DocumentStatusNotification;

class CandidateVerificationController extends Controller
{
    public function index()
    {
        $candidates = Candidate::with('documents')->get();
        return view('admin.candidates.verification.index', compact('candidates'));
    }


    public function verify(Request $request, CandidateDocument $document)
    {
        $request->validate([
            'status'=>'required|in:verified,rejected',
            'remarks'=>'required_if:status,rejected'
        ]);

        $document->update([
            'verification_status'=>$request->status,
            'remarks'=>$request->remarks,
            'verified_by'=>auth()->id(),
            'verified_at'=>now(),
        ]);

        // 🔔 Notification
        $document->candidate->notify(
            new DocumentStatusNotification($document)
        );

        // 🔄 Auto KYC status
        $this->updateKycStatus($document->candidate);

        return back()->with('success','Document verified');
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
