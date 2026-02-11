{{-- ================= ADDRESS CARD ================= --}}
<div class="bg-white rounded-xl shadow p-6 border">

    <div class="flex justify-between mb-4">
        <h3 class="font-semibold text-lg">Address Details</h3>

        <button onclick="openBulkModal('address')"
            class="bg-blue-600 text-white px-4 py-1 rounded text-xs">
            Bulk Update
        </button>
    </div>

    <table class="w-full text-sm">
        <thead class="bg-gray-100">
            <tr>
                <th class="p-2">Type</th>
                <th class="p-2">Address</th>
                <th class="p-2">Status</th>
                <th class="p-2">Action</th>
            </tr>
        </thead>

        <tbody>
        @foreach($candidate->addresses as $address)
        <tr class="border-t">
            <td class="p-2">{{ ucfirst($address->type) }}</td>
            <td class="p-2">{{ $address->full_address }}</td>
            <td class="p-2 text-center">
                <span class="px-2 py-1 rounded text-xs
                    @if($address->verification_status=='verified') bg-green-100 text-green-700
                    @elseif($address->verification_status=='rejected') bg-red-100 text-red-700
                    @else bg-yellow-100 text-yellow-700 @endif">
                    {{ ucfirst($address->verification_status ?? 'pending') }}
                </span>
            </td>
            <td class="p-2 text-center space-x-2">
                <button onclick="openModal('address',{{ $address->id }})"
                    class="bg-indigo-600 text-white px-3 py-1 rounded text-xs">
                    Update
                </button>

                <button onclick="openHistory('address',{{ $address->id }})"
                    class="bg-gray-700 text-white px-3 py-1 rounded text-xs">
                    History
                </button>
            </td>
        </tr>
        @endforeach
        </tbody>
    </table>
</div>
