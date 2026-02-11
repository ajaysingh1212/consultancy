@extends('admin.layouts.app')

@section('content')

<div class="space-y-8">

<h2 class="text-2xl font-bold">
    Candidate Verification Dashboard
</h2>

@forelse($candidates as $candidate)

<div class="bg-white rounded-xl shadow border">

    {{-- HEADER --}}
    <div class="flex justify-between items-center p-6 border-b bg-gray-50 rounded-t-xl">
        <div>
            <h3 class="text-lg font-semibold">
                {{ $candidate->full_name }}
            </h3>
            <p class="text-sm text-gray-500">
                Passport: {{ $candidate->passport_number ?? 'N/A' }}
            </p>
        </div>
    </div>

    {{-- TABLE --}}
    <div class="p-6 overflow-x-auto">

        <table class="min-w-full text-sm">
            <thead>
                <tr class="bg-gray-100 border-b">
                    <th class="p-3 text-left">Document</th>
                    <th class="p-3 text-center">File</th>
                    <th class="p-3 text-center">Status</th>
                    <th class="p-3 text-center">Remarks</th>
                    <th class="p-3 text-center">Action</th>
                </tr>
            </thead>

            <tbody class="divide-y">

            @forelse($candidate->documents as $doc)

            <tr>
                <td class="p-3 capitalize">
                    {{ str_replace('_',' ',$doc->document_type) }}
                </td>

                <td class="p-3 text-center">
                    <a href="{{ asset('storage/'.$doc->document_file) }}"
                       target="_blank"
                       class="text-blue-600 hover:underline">
                        View
                    </a>
                </td>

                <td class="p-3 text-center">
                    <span class="px-3 py-1 text-xs rounded-full {{ $doc->status_badge_class }}">
                        {{ ucfirst($doc->verification_status) }}
                    </span>
                </td>

                <td class="p-3 text-center text-xs text-red-600">
                    {{ $doc->remarks ?? '—' }}
                </td>

                <td class="p-3 text-center space-x-2">

                    @if($doc->verification_status !== 'verified')
                        <button onclick="openModal({{ $doc->id }})"
                            class="px-3 py-1 text-xs bg-blue-600 text-white rounded">
                            Update
                        </button>
                    @endif

                    <button onclick="openHistory({{ $doc->id }})"
                        class="px-3 py-1 text-xs bg-gray-800 text-white rounded">
                        History
                    </button>

                </td>
            </tr>

            @empty
            <tr>
                <td colspan="5" class="p-6 text-center text-gray-500">
                    No documents uploaded
                </td>
            </tr>
            @endforelse

            </tbody>
        </table>

    </div>

</div>

@empty
<div class="bg-white p-6 rounded shadow text-center text-gray-500">
    No candidates available
</div>
@endforelse

</div>


{{-- ================== MODALS & DRAWERS OUTSIDE TABLE ================== --}}
@foreach($candidates as $candidate)
    @foreach($candidate->documents as $doc)

    {{-- UPDATE MODAL --}}
    <div id="modal{{ $doc->id }}"
         class="fixed inset-0 bg-black bg-opacity-40 hidden items-center justify-center z-50">

        <div class="bg-white rounded-lg p-6 w-96 shadow-xl">

            <h4 class="font-semibold mb-4">
                Update {{ str_replace('_',' ',$doc->document_type) }}
            </h4>

            <form method="POST"
                  action="{{ route('admin.candidate.document.verify',$doc) }}">
                @csrf

                <select name="status"
                        class="w-full border rounded p-2 mb-3">
                    <option value="verified">Verified</option>
                    <option value="rejected">Rejected</option>
                </select>

                <textarea name="remarks"
                          class="w-full border rounded p-2 mb-3"
                          placeholder="Write remarks..."></textarea>

                <div class="flex justify-end gap-2">
                    <button type="button"
                            onclick="closeModal({{ $doc->id }})"
                            class="px-3 py-1 bg-gray-500 text-white rounded">
                        Cancel
                    </button>

                    <button class="px-3 py-1 bg-green-600 text-white rounded">
                        Save
                    </button>
                </div>

            </form>
        </div>
    </div>

    {{-- HISTORY DRAWER --}}
    <div id="history{{ $doc->id }}"
         class="fixed top-0 right-0 h-full w-96 bg-white shadow-2xl transform translate-x-full transition duration-300 z-40">

        <div class="p-4 border-b flex justify-between">
            <h4 class="font-semibold">Verification History</h4>
            <button onclick="closeHistory({{ $doc->id }})">✖</button>
        </div>

        <div class="p-4 overflow-y-auto h-full">

            @if($doc->histories->count())

            <table class="w-full text-xs">
                <thead class="bg-gray-100">
                    <tr>
                        <th class="p-2 text-left">Status</th>
                        <th class="p-2 text-left">Remarks</th>
                        <th class="p-2 text-left">By</th>
                        <th class="p-2 text-left">Date</th>
                    </tr>
                </thead>

                <tbody class="divide-y">
                @foreach($doc->histories as $history)
                    <tr>
                        <td class="p-2">{{ ucfirst($history->status) }}</td>
                        <td class="p-2">{{ $history->remarks }}</td>
                        <td class="p-2">{{ $history->admin->name ?? '-' }}</td>
                        <td class="p-2">
                            {{ $history->created_at->format('d M Y H:i') }}
                        </td>
                    </tr>
                @endforeach
                </tbody>

            </table>

            @else
                <p class="text-sm text-gray-500">
                    No history available
                </p>
            @endif

        </div>
    </div>

    @endforeach
@endforeach

@endsection


<script>
function openModal(id){
    let modal = document.getElementById('modal'+id);
    modal.classList.remove('hidden');
    modal.classList.add('flex');
}
function closeModal(id){
    document.getElementById('modal'+id).classList.add('hidden');
}

function openHistory(id){
    document.getElementById('history'+id)
        .classList.remove('translate-x-full');
}
function closeHistory(id){
    document.getElementById('history'+id)
        .classList.add('translate-x-full');
}
</script>
