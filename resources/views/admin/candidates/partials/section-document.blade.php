{{-- ================= DOCUMENT CARD ================= --}}
<div class="bg-white rounded-xl shadow p-6 border">

    <div class="flex justify-between mb-4">
        <h3 class="font-semibold text-lg">Document Verification</h3>

        <button onclick="openBulkModal('document')"
            class="bg-blue-600 text-white px-4 py-1 rounded text-xs">
            Bulk Update
        </button>
    </div>

    <div class="grid md:grid-cols-3 gap-6">

        @foreach($candidate->documents as $doc)
        <div class="border rounded-lg p-4 shadow-sm">

            <h4 class="font-semibold capitalize mb-2">
                {{ str_replace('_',' ',$doc->document_type) }}
            </h4>

            <img src="{{ asset('storage/'.$doc->document_file) }}"
                 class="w-full h-40 object-cover rounded mb-3">

            <div class="flex justify-between items-center">
                <span class="px-2 py-1 rounded text-xs {{ $doc->status_badge_class }}">
                    {{ ucfirst($doc->verification_status) }}
                </span>

                <div class="space-x-1">
                    <button onclick="openModal('document',{{ $doc->id }})"
                        class="bg-indigo-600 text-white px-3 py-1 rounded text-xs">
                        Update
                    </button>

                    <button onclick="openHistory('document',{{ $doc->id }})"
                        class="bg-gray-700 text-white px-3 py-1 rounded text-xs">
                        History
                    </button>
                </div>
            </div>

        </div>
        @endforeach

    </div>
</div>
