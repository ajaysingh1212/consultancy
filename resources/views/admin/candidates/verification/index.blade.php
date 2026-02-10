@extends('admin.layouts.app')

@section('content')

<h2 class="text-2xl font-bold mb-6">
    Candidate Verification Dashboard
</h2>

@forelse($candidates as $candidate)
<div class="bg-white p-5 mb-6 rounded-lg shadow">

    {{-- CANDIDATE HEADER --}}
    <div class="flex justify-between items-center mb-4">
        <h3 class="font-semibold text-lg">
            {{ $candidate->full_name }}
            <span class="text-sm text-gray-500">
                (Passport: {{ $candidate->passport_number ?? 'N/A' }})
            </span>
        </h3>

        {{-- KYC PROGRESS --}}
        <div class="w-40">
            <div class="text-xs mb-1 text-right">
                {{ $candidate->kyc_completion }}%
            </div>
            <div class="w-full bg-gray-200 rounded h-2">
                <div class="bg-green-600 h-2 rounded"
                     style="width: {{ $candidate->kyc_completion }}%">
                </div>
            </div>
        </div>
    </div>

    {{-- DOCUMENT TABLE --}}
    <table class="w-full text-sm border">
        <thead class="bg-gray-100">
            <tr>
                <th class="border p-2 text-left">Document</th>
                <th class="border p-2">File</th>
                <th class="border p-2">Status</th>
                <th class="border p-2">Remarks</th>
                <th class="border p-2">Action</th>
            </tr>
        </thead>

        <tbody>
        @forelse($candidate->documents as $doc)
            <tr class="border-t">
                <td class="border p-2 capitalize">
                    {{ str_replace('_',' ',$doc->document_type) }}
                </td>

                <td class="border p-2 text-center">
                    <a href="{{ asset('storage/'.$doc->document_file) }}"
                       target="_blank"
                       class="text-blue-600 underline">
                        View
                    </a>
                </td>

                <td class="border p-2 text-center">
                    <span class="px-2 py-1 rounded text-xs {{ $doc->status_badge_class }}">
                        {{ ucfirst($doc->verification_status) }}
                    </span>
                </td>

                <td class="border p-2 text-xs text-red-600">
                    {{ $doc->remarks ?? '—' }}
                </td>

                <td class="border p-2 text-center">
                    @if($doc->verification_status === 'pending')
                        {{-- VERIFY --}}
                        <form method="POST"
                              action="{{ route('admin.candidate.document.verify',$doc) }}"
                              class="inline">
                            @csrf
                            <input type="hidden" name="status" value="verified">
                            <button class="bg-green-600 text-white px-2 py-1 rounded text-xs">
                                Verify
                            </button>
                        </form>

                        {{-- REJECT --}}
                        <button onclick="openReject({{ $doc->id }})"
                                class="bg-red-600 text-white px-2 py-1 rounded text-xs ml-1">
                            Reject
                        </button>

                        @include('admin.candidates.partials.reject-modal',['doc'=>$doc])
                    @else
                        —
                    @endif
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="5" class="p-3 text-center text-gray-500">
                    No documents uploaded
                </td>
            </tr>
        @endforelse
        </tbody>
    </table>

</div>
@empty
<div class="bg-white p-6 rounded shadow text-center text-gray-500">
    No candidates available for verification
</div>
@endforelse

@endsection

{{-- JS --}}
<script>
function openReject(id){
    document.getElementById('rejectModal'+id).classList.remove('hidden');
}
function closeReject(id){
    document.getElementById('rejectModal'+id).classList.add('hidden');
}
</script>
