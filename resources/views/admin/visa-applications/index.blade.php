@extends('admin.layouts.app')

@section('content')

<style>
.action-btn {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    padding: 8px 10px;
    border-radius: 8px;
    font-size: 14px;
    font-weight: 600;
    transition: 0.2s ease;
    position: relative;
}

.action-btn:hover {
    transform: translateY(-2px);
}

.action-btn:hover::after {
    content: attr(data-text);
    position: absolute;
    bottom: -28px;
    background: #111827;
    color: white;
    font-size: 11px;
    padding: 4px 8px;
    border-radius: 6px;
    white-space: nowrap;
}
</style>

<div class="max-w-7xl mx-auto mt-10">

    <div class="flex justify-between items-center mb-8">
        <h2 class="text-3xl font-bold text-[#7c3aed] flex items-center gap-3">
            🛂 Visa Applications
        </h2>

        <a href="{{ route('admin.visa-applications.create') }}"
           class="bg-gradient-to-r from-purple-600 to-purple-500 text-white px-6 py-3 rounded-xl shadow-lg hover:scale-105 transition duration-200">
            ➕ New Application
        </a>
    </div>

    <div class="bg-white shadow-2xl rounded-3xl overflow-hidden p-6">

        <table class="datatable w-full text-sm">
            <thead class="bg-purple-50 text-left text-gray-700">
                <tr>
                    <th class="p-4">Candidate</th>
                    <th>Country</th>
                    <th>Visa Type</th>
                    <th>Status</th>
                    <th>Expiry</th>
                    <th>Total Cost</th>
                    <th class="text-right p-4">Action</th>
                </tr>
            </thead>

            <tbody>
                @foreach($visaApplications as $visa)
                <tr class="border-t hover:bg-purple-50 transition duration-150">

                    <td class="p-4 font-semibold">
                        {{ $visa->candidate->full_name ?? '-' }}
                    </td>

                    <td>{{ $visa->country }}</td>
                    <td>{{ $visa->visa_type }}</td>

                    <td>
                        @if($visa->visa_status == 'approved')
                            <span class="px-3 py-1 bg-green-100 text-green-600 rounded-full text-xs">Approved</span>
                        @elseif($visa->visa_status == 'processing')
                            <span class="px-3 py-1 bg-yellow-100 text-yellow-600 rounded-full text-xs">Processing</span>
                        @else
                            <span class="px-3 py-1 bg-red-100 text-red-600 rounded-full text-xs">Rejected</span>
                        @endif
                    </td>

                    <td>
                        @if($visa->is_expired)
                            <span class="text-red-600 font-semibold">Expired</span>
                        @else
                            {{ optional($visa->visa_expiry_date)->format('d M Y') }}
                        @endif
                    </td>

                    <td class="font-medium">
                        ₹ {{ number_format($visa->total_cost,2) }}
                    </td>

                    <td class="p-4 text-right space-x-2">

                        <a href="{{ route('admin.visa-applications.show',$visa) }}"
                           class="action-btn bg-blue-100 text-blue-600"
                           data-text="View">👁</a>

                        <a href="{{ route('admin.visa-applications.edit',$visa) }}"
                           class="action-btn bg-yellow-100 text-yellow-600"
                           data-text="Edit">✏</a>

                        <form action="{{ route('admin.visa-applications.destroy',$visa) }}"
                              method="POST" class="inline">
                            @csrf
                            @method('DELETE')
                            <button class="action-btn bg-red-100 text-red-600"
                                    data-text="Delete"
                                    onclick="return confirm('Delete this application?')">
                                🗑
                            </button>
                        </form>

                        <button onclick="openStageModal({{ $visa->id }},'medical')"
                                class="action-btn bg-green-100 text-green-600"
                                data-text="Medical">💉</button>

                        <button onclick="openStageModal({{ $visa->id }},'pcc')"
                                class="action-btn bg-orange-100 text-orange-600"
                                data-text="PCC">🪪</button>

                        <button onclick="openStageModal({{ $visa->id }},'visa_submitted')"
                                class="action-btn bg-indigo-100 text-indigo-600"
                                data-text="Submitted">📤</button>

                        <button onclick="openStageModal({{ $visa->id }},'visa_approved')"
                                class="action-btn bg-emerald-100 text-emerald-600"
                                data-text="Approved">✅</button>

                        <button onclick="openStageModal({{ $visa->id }},'ticket_issued')"
                                class="action-btn bg-sky-100 text-sky-600"
                                data-text="Ticket">🎫</button>

                        <button onclick="openStageModal({{ $visa->id }},'deployment')"
                                class="action-btn bg-purple-100 text-purple-600"
                                data-text="Deploy">🚀</button>

                        <button onclick="openHistory({{ $visa->id }})"
                                class="action-btn bg-gray-100 text-gray-600"
                                data-text="History">📜</button>

                    </td>

                </tr>
                @endforeach
            </tbody>
        </table>

    </div>

</div>

<!-- STAGE MODAL -->
<div id="stageModal"
     class="fixed inset-0 bg-black/50 hidden items-center justify-center z-50 transition" >

    <div class="bg-white p-8 rounded-2xl w-96 shadow-2xl">
        <form method="POST" id="stageForm">
            @csrf
            <input type="hidden" name="stage" id="stageInput">

            <label class="block font-semibold mb-2">Date</label>
            <input type="date" name="stage_date"
                   class="border w-full p-2 mb-4 rounded">

            <label class="block font-semibold mb-2">Status</label>
            <input type="text" name="status"
                   class="border w-full p-2 mb-4 rounded">

            <label class="block font-semibold mb-2">Remarks</label>
            <textarea name="remarks"
                      class="border w-full p-2 mb-4 rounded"></textarea>

            <div class="flex justify-end gap-3">
                <button type="button"
                        onclick="closeModal()"
                        class="px-4 py-2 bg-gray-200 rounded">
                    Cancel
                </button>
                <button class="bg-purple-600 text-white px-4 py-2 rounded">
                    Update
                </button>
            </div>
        </form>
    </div>
</div>

<!-- HISTORY SIDEBAR -->
<div id="historySidebar"
     class="fixed top-0 right-0 w-96 h-full bg-white shadow-2xl transform translate-x-full transition duration-300 overflow-y-auto p-6 z-50">

    <div class="flex justify-between items-center mb-6">
        <h3 class="text-xl font-bold">Stage History</h3>
        <button onclick="closeHistory()">✖</button>
    </div>

    <div id="historyContent"></div>

</div>

@endsection


@push('scripts')
<script>

function openStageModal(id, stage)
{
    document.getElementById('stageModal').classList.remove('hidden');
    document.getElementById('stageInput').value = stage;
    document.getElementById('stageForm').action =
        `/admin/visa-applications/${id}/update-stage`;
}

function closeModal()
{
    document.getElementById('stageModal').classList.add('hidden');
}

function openHistory(id)
{
    fetch(`/admin/visa-applications/${id}/history`)
    .then(res => res.json())
    .then(data => {

        let html = '';

        data.forEach(item => {
            html += `
                <div class="mb-4 border-b pb-3">
                    <strong class="text-purple-600">${item.stage}</strong><br>
                    Date: ${item.stage_date ?? '-'}<br>
                    Status: ${item.status ?? '-'}<br>
                    Remarks: ${item.remarks ?? '-'}<br>
                    <span class="text-xs text-gray-500">
                        ${new Date(item.created_at).toLocaleString()}
                    </span>
                </div>
            `;
        });

        document.getElementById('historyContent').innerHTML = html;
        document.getElementById('historySidebar')
            .classList.remove('translate-x-full');
    });
}

function closeHistory()
{
    document.getElementById('historySidebar')
        .classList.add('translate-x-full');
}

</script>
@endpush
