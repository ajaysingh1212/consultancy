<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\VisaDocument;
use App\Models\VisaApplication;
use App\Models\Candidate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class VisaDocumentController extends Controller
{

    /* =====================================================
        INDEX
    ===================================================== */

    public function index()
    {
        $documents = VisaDocument::with([
                'candidate',
                'visaApplication',
                'verifier'
            ])
            ->latest()
            ->paginate(20);

        return view('admin.visa-documents.index', compact('documents'));
    }

    /* =====================================================
        CREATE
    ===================================================== */

    public function create()
    {
        $visaApplications = VisaApplication::with('candidate')->get();

        return view('admin.visa-documents.create', compact('visaApplications'));
    }

    /* =====================================================
        STORE
    ===================================================== */

    public function store(Request $request)
    {
        $data = $request->validate([

            'visa_application_id' => 'required|exists:visa_applications,id',
            'document_type'       => 'required|string|max:255',
            'document_number'     => 'nullable|string|max:255',

            'issued_date'         => 'nullable|date',
            'expiry_date'         => 'nullable|date',

            'file'                => 'required|file|max:5120',
            'remarks'             => 'nullable|string',
        ]);

        $visaApplication = VisaApplication::findOrFail($data['visa_application_id']);

        // Upload File
        $file = $request->file('file');
        $path = $file->store('visa-documents', 'public');

        VisaDocument::create([
            'visa_application_id' => $data['visa_application_id'],
            'candidate_id'        => $visaApplication->candidate_id,

            'document_type'       => $data['document_type'],
            'document_number'     => $data['document_number'] ?? null,

            'file_path'           => $path,
            'file_name'           => $file->getClientOriginalName(),
            'file_size'           => $file->getSize(),
            'mime_type'           => $file->getMimeType(),

            'issued_date'         => $data['issued_date'] ?? null,
            'expiry_date'         => $data['expiry_date'] ?? null,

            'verification_status' => 'pending',
            'remarks'             => $data['remarks'] ?? null,
        ]);

        return redirect()
            ->route('admin.visa-documents.index')
            ->with('success','Visa document uploaded successfully.');
    }

    /* =====================================================
        SHOW
    ===================================================== */

    public function show(VisaDocument $visaDocument)
    {
        $visaDocument->load([
            'candidate',
            'visaApplication',
            'verifier'
        ]);

        return view('admin.visa-documents.show', compact('visaDocument'));
    }

    /* =====================================================
        EDIT
    ===================================================== */

    public function edit(VisaDocument $visaDocument)
    {
        $visaApplications = VisaApplication::with('candidate')->get();

        return view('admin.visa-documents.edit', compact('visaDocument','visaApplications'));
    }

    /* =====================================================
        UPDATE
    ===================================================== */

    public function update(Request $request, VisaDocument $visaDocument)
    {
        $data = $request->validate([

            'visa_application_id' => 'required|exists:visa_applications,id',
            'document_type'       => 'required|string|max:255',
            'document_number'     => 'nullable|string|max:255',

            'issued_date'         => 'nullable|date',
            'expiry_date'         => 'nullable|date',

            'file'                => 'nullable|file|max:5120',
            'remarks'             => 'nullable|string',
        ]);

        $updateData = [
            'visa_application_id' => $data['visa_application_id'],
            'document_type'       => $data['document_type'],
            'document_number'     => $data['document_number'] ?? null,
            'issued_date'         => $data['issued_date'] ?? null,
            'expiry_date'         => $data['expiry_date'] ?? null,
            'remarks'             => $data['remarks'] ?? null,
        ];

        // If new file uploaded
        if ($request->hasFile('file')) {

            if ($visaDocument->file_path && Storage::disk('public')->exists($visaDocument->file_path)) {
                Storage::disk('public')->delete($visaDocument->file_path);
            }

            $file = $request->file('file');
            $path = $file->store('visa-documents', 'public');

            $updateData['file_path'] = $path;
            $updateData['file_name'] = $file->getClientOriginalName();
            $updateData['file_size'] = $file->getSize();
            $updateData['mime_type'] = $file->getMimeType();
        }

        $visaDocument->update($updateData);

        return redirect()
            ->route('admin.visa-documents.index')
            ->with('success','Visa document updated successfully.');
    }

    /* =====================================================
        VERIFY DOCUMENT
    ===================================================== */

    public function verify(Request $request, VisaDocument $visaDocument)
    {
        $request->validate([
            'status'  => 'required|in:verified,rejected',
            'remarks' => 'nullable|string'
        ]);

        $visaDocument->update([
            'verification_status' => $request->status,
            'verified_by'         => auth()->id(),
            'verified_at'         => now(),
            'remarks'             => $request->remarks
        ]);

        return back()->with('success','Document status updated successfully.');
    }

    /* =====================================================
        DESTROY
    ===================================================== */

    public function destroy(VisaDocument $visaDocument)
    {
        if ($visaDocument->file_path && Storage::disk('public')->exists($visaDocument->file_path)) {
            Storage::disk('public')->delete($visaDocument->file_path);
        }

        $visaDocument->delete();

        return redirect()
            ->route('admin.visa-documents.index')
            ->with('success','Visa document deleted successfully.');
    }
}
