<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Candidate;
use App\Models\CandidateAddress;
use App\Models\CandidateDocument;
use App\Models\CandidateEducation;
use App\Models\DocumentVerificationHistory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class CandidateVerificationController extends Controller
{

    public function index()
    {
        $candidates = Candidate::with(['documents.histories.admin'])->get();
        return view('admin.candidates.verification.index', compact('candidates'));
    }

    /* =========================================================
       DOCUMENT VERIFY (Single)
    ========================================================= */

    public function verify(Request $request, CandidateDocument $document)
    {
        $request->validate([
            'status'  => 'required|in:verified,rejected',
            'remarks' => 'nullable|string'
        ]);

        $document->update([
            'verification_status' => $request->status,
            'remarks'             => $request->remarks,
            'verified_by'         => auth()->id(),
            'verified_at'         => now(),
        ]);

        DocumentVerificationHistory::create([
            'document_id' => $document->id,
            'action_by'   => auth()->id(),
            'status'      => $request->status,
            'remarks'     => $request->remarks,
        ]);

        $this->sendMailToCandidate(
            $document->candidate,
            "Your document ({$document->document_type}) has been {$request->status}.",
            $request->remarks
        );

        $this->updateKycStatus($document->candidate);

        return back()->with('success','Document status updated');
    }

    /* =========================================================
       ADDRESS VERIFY
    ========================================================= */

    public function verifyAddress(Request $request, Candidate $candidate)
    {
        foreach($request->addresses as $id => $data){

            $address = $candidate->addresses()->find($id);

            if(!$address) continue;

            $address->update([
                'verification_status' => $data['status'],
                'remarks'             => $data['remarks'] ?? null,
                'verified_by'         => auth()->id(),
                'verified_at'         => now(),
            ]);

            $this->sendMailToCandidate(
                $candidate,
                "Your address record has been {$data['status']}.",
                $data['remarks'] ?? null
            );
        }

        return back()->with('success','Address verification updated');
    }

    /* =========================================================
       EDUCATION VERIFY
    ========================================================= */

    public function verifyEducation(Request $request, Candidate $candidate)
    {
        foreach($request->educations as $id => $data){

            $edu = $candidate->educations()->find($id);

            if(!$edu) continue;

            $edu->update([
                'verification_status' => $data['status'],
                'remarks'             => $data['remarks'] ?? null,
                'verified_by'         => auth()->id(),
                'verified_at'         => now(),
            ]);

            $this->sendMailToCandidate(
                $candidate,
                "Your education record has been {$data['status']}.",
                $data['remarks'] ?? null
            );
        }

        return back()->with('success','Education verification updated');
    }

    /* =========================================================
       DOCUMENT VERIFY (Bulk)
    ========================================================= */

    public function verifyDocuments(Request $request, Candidate $candidate)
    {
        foreach($request->documents as $id => $data){

            $doc = $candidate->documents()->find($id);

            if(!$doc) continue;

            $doc->update([
                'verification_status' => $data['status'],
                'remarks'             => $data['remarks'] ?? null,
                'verified_by'         => auth()->id(),
                'verified_at'         => now(),
            ]);

            $this->sendMailToCandidate(
                $candidate,
                "Document ({$doc->document_type}) has been {$data['status']}.",
                $data['remarks'] ?? null
            );
        }

        return back()->with('success','Document verification updated');
    }

    /* =========================================================
       HISTORY
    ========================================================= */

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

    /* =========================================================
       BULK APPROVE
    ========================================================= */

    public function bulkApprove($type, Candidate $candidate)
    {
        if($type === 'address'){
            $candidate->addresses()->update([
                'verification_status'=>'verified',
                'verified_by'=>auth()->id(),
                'verified_at'=>now(),
            ]);
        }

        if($type === 'education'){
            $candidate->educations()->update([
                'verification_status'=>'verified',
                'verified_by'=>auth()->id(),
                'verified_at'=>now(),
            ]);
        }

        if($type === 'document'){
            $candidate->documents()->update([
                'verification_status'=>'verified',
                'verified_by'=>auth()->id(),
                'verified_at'=>now(),
            ]);
        }

        $candidate->update(['kyc_status'=>'verified']);

        $this->sendMailToCandidate(
            $candidate,
            "All your {$type} records have been approved.",
            null
        );

        return back()->with('success','All approved successfully');
    }

    /* =========================================================
       UPDATE ADDRESS STATUS
    ========================================================= */

    public function updateAddressStatus(Request $request, CandidateAddress $address)
    {
        $request->validate([
            'status' => 'required|in:verified,pending,rejected',
            'remarks' => 'nullable|string'
        ]);

        $address->update([
            'verification_status' => $request->status,
            'remarks'             => $request->remarks,
            'verified_by'         => auth()->id(),
            'verified_at'         => now(),
        ]);

        $this->sendMailToCandidate(
            $address->candidate,
            "Your address has been {$request->status}.",
            $request->remarks
        );

        return back()->with('success','Address updated successfully');
    }

    /* =========================================================
       UPDATE EDUCATION STATUS
    ========================================================= */

    public function updateEducationStatus(Request $request, CandidateEducation $education)
    {
        $request->validate([
            'status' => 'required|in:verified,pending,rejected',
            'remarks' => 'nullable|string'
        ]);

        $education->update([
            'verification_status' => $request->status,
            'remarks'             => $request->remarks,
            'verified_by'         => auth()->id(),
            'verified_at'         => now(),
        ]);

        $this->sendMailToCandidate(
            $education->candidate,
            "Your education record has been {$request->status}.",
            $request->remarks
        );

        return back()->with('success','Education updated successfully');
    }

    /* =========================================================
       UPDATE DOCUMENT STATUS
    ========================================================= */

    public function updateDocumentStatus(Request $request, CandidateDocument $document)
    {
        $request->validate([
            'status' => 'required|in:verified,pending,rejected',
            'remarks' => 'nullable|string'
        ]);

        $document->update([
            'verification_status' => $request->status,
            'remarks'             => $request->remarks,
            'verified_by'         => auth()->id(),
            'verified_at'         => now(),
        ]);

        DocumentVerificationHistory::create([
            'document_id' => $document->id,
            'action_by'   => auth()->id(),
            'status'      => $request->status,
            'remarks'     => $request->remarks,
        ]);

        $this->sendMailToCandidate(
            $document->candidate,
            "Your document ({$document->document_type}) status has been updated to {$request->status}.",
            $request->remarks
        );

        return back()->with('success','Document updated successfully');
    }

    /* =========================================================
       KYC STATUS LOGIC
    ========================================================= */

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

    /* =========================================================
       COMMON MAIL FUNCTION
    ========================================================= */

    private function sendMailToCandidate($candidate, $message, $remarks = null)
    {
        if(!$candidate || !$candidate->email){
            return;
        }

        Mail::raw(
            "Hello {$candidate->full_name},\n\n{$message}\n\nRemarks: {$remarks}\n\nRegards,\nAdmin Team",
            function($mail) use ($candidate){
                $mail->to($candidate->email)
                     ->subject('KYC Verification Update');
            }
        );
    }
}
