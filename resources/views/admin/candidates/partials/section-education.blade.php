{{-- ================= EDUCATION CARD ================= --}}
<div class="bg-white rounded-xl shadow p-6 border">

    <div class="flex justify-between mb-4">
        <h3 class="font-semibold text-lg">Education Details</h3>

        <button onclick="openBulkModal('education')"
            class="bg-blue-600 text-white px-4 py-1 rounded text-xs">
            Bulk Update
        </button>
    </div>

    <table class="w-full text-sm">
        <thead class="bg-gray-100">
            <tr>
                <th class="p-2">P. Year</th>
                <th class="p-2">Board</th>
                <th class="p-2">Roll No.</th>
                <th class="p-2">Roll Code</th>
                <th class="p-2">Marks</th>
                <th class="p-2">Status</th>

                <th class="p-2">Action</th>
            </tr>
        </thead>

        <tbody>
        @foreach($candidate->educations as $edu)
        <tr class="border-t">
            <td class="p-2">{{ ucfirst($edu->passing_year) }}</td>
            <td class="p-2">{{ $edu->board_university }}</td>
            <td class="p-2">{{ $edu->roll_no }}</td>
            <td class="p-2">{{ $edu->roll_code }}</td>
            <td class="p-2">{{ $edu->marks }}</td>
            <td class="p-2 text-center">
                <span class="px-2 py-1 rounded text-xs
                    @if($edu->verification_status=='verified') bg-green-100 text-green-700
                    @elseif($edu->verification_status=='rejected') bg-red-100 text-red-700
                    @else bg-yellow-100 text-yellow-700 @endif">
                    {{ ucfirst($edu->verification_status ?? 'pending') }}
                </span>
            </td>
            <td class="p-2 text-center space-x-2">
                <button onclick="openModal('education',{{ $edu->id }})"
                    class="bg-indigo-600 text-white px-3 py-1 rounded text-xs">
                    Update
                </button>

                <button onclick="openHistory('education',{{ $edu->id }})"
                    class="bg-gray-700 text-white px-3 py-1 rounded text-xs">
                    History
                </button>
            </td>
        </tr>
        @endforeach
        </tbody>
    </table>
</div>
