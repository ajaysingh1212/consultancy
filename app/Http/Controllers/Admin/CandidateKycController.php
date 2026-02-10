<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Candidate;
use App\Models\CandidateAddress;
use App\Models\CandidateEducation;
use Illuminate\Http\Request;

class CandidateKycController extends Controller
{
    /**
     * Show candidate KYC page
     */
    public function show(Candidate $candidate)
    {
        $candidate->load([
            'addresses',
            'educations',
            'documents'
        ]);

        return view('admin.candidates.kyc', compact('candidate'));
    }

    public function store(Request $request, Candidate $candidate)
    {
        /*
        |--------------------------------------------------------------------------
        | 1. UPDATE CANDIDATE BASIC + KYC STATUS
        |--------------------------------------------------------------------------
        */
        if ($candidate->kyc_status !== 'verified') {
            $candidate->update([
                'kyc_status'   => 'partial',
                'father_name'  => $request->father_name ?? null,
                'aadhaar_no'   => $request->aadhaar_no ?? null,
                'pan_no'       => $request->pan_no ?? null,
                'bank_name'    => $request->bank_name ?? null,
                'account_no'   => $request->account_no ?? null,
                'ifsc'         => $request->ifsc ?? null,
            ]);
        }

        /*
        |--------------------------------------------------------------------------
        | 2. ADDRESS (UPDATE OR CREATE)
        |--------------------------------------------------------------------------
        | One candidate → one present address
        |--------------------------------------------------------------------------
        */
        if ($request->filled('address')) {
            CandidateAddress::updateOrCreate(
                [
                    'candidate_id' => $candidate->id,
                    'type' => 'present',
                ],
                [
                    'address' => $request->address,
                    'city'    => $request->city ?? null,
                    'state'   => $request->state ?? null,
                    'country' => 'India',
                    'pincode' => $request->pincode ?? null,
                ]
            );
        }

        /*
        |--------------------------------------------------------------------------
        | 3. EDUCATION (DELETE & RE-CREATE – ENUM SAFE & NO OVERWRITE)
        |--------------------------------------------------------------------------
        */

        // UI → DB ENUM mapping
        $levelMap = [
            'Matric'        => 'matric',
            '8th'           => 'matric',
            'Eight'         => 'matric',

            '10th'          => 'matric',

            '12th'          => 'intermediate',
            'Intermediate' => 'intermediate',

            'Graduation'   => 'graduation',
            'graduation'   => 'graduation',

            'ITI'          => 'other',
            'Iti'          => 'other',
            'Diploma'      => 'other',
            'Other'        => 'other',
        ];

        // 🔥 IMPORTANT: purane education records hatao
        $candidate->educations()->delete();

        if ($request->has('qualification') && isset($request->qualification['level'])) {

            foreach ($request->qualification['level'] as $index => $level) {

                if (empty($level)) {
                    continue;
                }

                $dbLevel = $levelMap[$level] ?? 'other';

                CandidateEducation::create([
                    'candidate_id'        => $candidate->id,
                    'level'               => $dbLevel,
                    'board_university'    => $request->qualification['board'][$index] ?? null,
                    'roll_no'             => $request->qualification['roll_no'][$index] ?? null,
                    'roll_code'           => $request->qualification['roll_code'][$index] ?? null,
                    'passing_year'        => $request->qualification['year'][$index] ?? null,
                    'marks'               => $request->qualification['marks'][$index] ?? null,
                    'institution'         => null,
                    'certificate'         => null,
                    'verification_status' => 'pending',
                ]);
            }
        }

        /*
        |--------------------------------------------------------------------------
        | 4. REDIRECT
        |--------------------------------------------------------------------------
        */
        return redirect()
            ->route('admin.candidates.kyc.show', $candidate)
            ->with('success', 'KYC details saved successfully');
    }

}
