<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Mail\OtpMail;
use App\Models\Candidate;
use App\Models\CandidateBiometric;
use App\Models\CandidateDocument;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;


class CandidateController extends Controller
{
    public function index()
    {
        $candidates = Candidate::latest()->get();
        return view('admin.candidates.index', compact('candidates'));
    }

    public function create()
    {
        return view('admin.candidates.create');
    }

    public function store(Request $request)
    {

        $candidate = Candidate::create($request->validate([
            'full_name'       => 'required|string|max:255',
            'mobile'          => 'required|unique:candidates,mobile',
            'email'           => 'required|email|unique:candidates,email',
            'passport_number' => 'required|unique:candidates,passport_number',
            'dob'             => 'required|date',
            'gender'          => 'required',
            'marital_status'  => 'required',
            'nationality'     => 'required',
            'passport_expiry' => 'required|date',
        ]));

        return redirect()->route('admin.candidates.index')
            ->with('success','Candidate created successfully');
    }

    public function show(Candidate $candidate)
    {
        return view('admin.candidates.show', compact('candidate'));
    }

    public function edit(Candidate $candidate)
    {
        return view('admin.candidates.edit', compact('candidate'));
    }

    public function update(Request $request, Candidate $candidate)
    {
        $candidate->update($request->all());

        return redirect()->route('admin.candidates.index')
            ->with('success','Candidate updated');
    }

    public function destroy(Candidate $candidate)
    {
        $candidate->delete();

        return back()->with('success','Candidate deleted');
    }
    public function documents(Candidate $candidate)
    {
        $candidate->load('documents');

        return view('admin.candidates.documents', compact('candidate'));
    }
    public function storeDocuments(Request $request, Candidate $candidate)
    {
        /*
        |--------------------------------------------------------------------------
        | 1. FIXED DOCUMENTS (AADHAAR, PAN, PASSPORT, MARKSHEETS)
        |--------------------------------------------------------------------------
        */

        if ($request->hasFile('documents')) {
            foreach ($request->file('documents') as $type => $file) {

                // skip empty
                if (!$file) {
                    continue;
                }

                $path = $file->store('candidate_documents', 'public');

                CandidateDocument::create([
                    'candidate_id'       => $candidate->id,
                    'document_type'      => $type,
                    'document_file'      => $path,
                    'verification_status'=> 'pending',
                ]);
            }
        }

        /*
        |--------------------------------------------------------------------------
        | 2. EXTRA DOCUMENTS (➕ ADD MORE)
        |--------------------------------------------------------------------------
        */

        if ($request->filled('extra_doc_name')) {
            foreach ($request->extra_doc_name as $index => $name) {

                if (
                    empty($name) ||
                    !isset($request->extra_doc_file[$index])
                ) {
                    continue;
                }

                $file = $request->extra_doc_file[$index];
                $path = $file->store('candidate_documents', 'public');

                CandidateDocument::create([
                    'candidate_id'       => $candidate->id,
                    'document_type'      => $name,
                    'document_file'      => $path,
                    'verification_status'=> 'pending',
                ]);
            }
        }

        return redirect()
            ->route('admin.candidates.documents', $candidate)
            ->with('success', 'Documents uploaded successfully');
    }
    public function profile(Candidate $candidate)
    {
        $candidate->load([
            'addresses',
            'educations',
            'documents.verifier',
            'documents.histories'
        ]);

        return view('admin.candidates.show', compact('candidate'));
    }
    public function biometric(Candidate $candidate)
    {
        return view('admin.candidates.biometric',compact('candidate'));
    }

    public function biometricStore(Request $request, Candidate $candidate)
    {
        $data = $request->all();
        $data['candidate_id'] = $candidate->id;

        CandidateBiometric::updateOrCreate(
            ['candidate_id'=>$candidate->id],
            $data
        );

        return back()->with('success','Biometric Saved Successfully');
    }


public function sendOtp(Request $request)
{
    try {

        $request->validate([
            'email' => 'required|email'
        ]);

        // Generate new OTP every time (no timing restriction)
        $otp = rand(100000, 999999);

        // Overwrite old OTP data
        Session::put('email_otp', $otp);
        Session::put('email_for_otp', $request->email);
        Session::put('otp_expires_at', now()->addMinutes(5));
        Session::put('otp_attempts', 0);

        // Send email
        Mail::to($request->email)
            ->send(new OtpMail($otp, $request->email));

        return response()->json([
            'success' => true,
            'message' => 'OTP sent successfully.'
        ]);

    } catch (\Illuminate\Validation\ValidationException $e) {

        return response()->json([
            'success' => false,
            'message' => $e->errors()['email'][0] ?? 'Invalid email address.'
        ], 422);

    } catch (\Exception $e) {

        \Log::error("OTP Send Failed", [
            'error' => $e->getMessage(),
            'email' => $request->email ?? null
        ]);

        return response()->json([
            'success' => false,
            'message' => 'Something went wrong. Please try again.'
        ], 500);
    }
}



public function verifyOtp(Request $request)
{
    $request->validate([
        'otp' => 'required|digits:6'
    ]);

    // Check if OTP exists
    if (!Session::has('email_otp')) {
        return response()->json([
            'success' => false,
            'message' => 'OTP expired. Please request a new one.'
        ], 400);
    }

    // Check expiry
    if (now()->greaterThan(Session::get('otp_expires_at'))) {

        Session::forget([
            'email_otp',
            'otp_expires_at',
            'otp_attempts'
        ]);

        return response()->json([
            'success' => false,
            'message' => 'OTP expired.'
        ], 400);
    }

    // Attempt limit
    $attempts = Session::get('otp_attempts', 0);

    if ($attempts >= 5) {

        Session::forget([
            'email_otp',
            'otp_expires_at',
            'otp_attempts'
        ]);

        return response()->json([
            'success' => false,
            'message' => 'Too many attempts. Please request new OTP.'
        ], 429);
    }

    // Check OTP
    if ($request->otp == Session::get('email_otp')) {

        Session::forget([
            'email_otp',
            'otp_expires_at',
            'otp_attempts'
        ]);

        Session::put('email_verified', true);

        return response()->json([
            'success' => true,
            'message' => 'Email verified successfully.'
        ]);
    }

    // Increment attempts
    Session::put('otp_attempts', $attempts + 1);

    return response()->json([
        'success' => false,
        'message' => 'Invalid OTP.',
        'attempts_left' => 5 - ($attempts + 1)
    ]);
}
public function showJson($id)
{
    $candidate = \App\Models\Candidate::with([
        'skills',
        'applications.job',
        'documents',
        'presentAddress',
        'permanentAddress',
        'educations',
    ])->findOrFail($id);

    return response()->json($candidate);
}
}
