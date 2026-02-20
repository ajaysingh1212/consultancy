@extends('admin.layouts.app')

@section('content')

<div class="max-w-7xl mx-auto mt-10">

    <div class="flex justify-between items-center mb-6">
        <h2 class="text-3xl font-bold text-[#7c3aed]">🛂 Visa Applications</h2>

        <a href="{{ route('admin.visa-applications.create') }}"
           class="bg-[#7c3aed] text-white px-6 py-3 rounded-xl shadow hover:bg-[#6d28d9] transition">
            + New Application
        </a>
    </div>

    <div class="bg-white shadow-xl rounded-3xl overflow-hidden " style="padding: 20px;">

        <table class="datatable w-full text-sm">
            <thead class="bg-[#f5f3ff] text-left">
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
                <tr class="border-t hover:bg-[#faf5ff]">

                    <td class="p-4 font-medium">
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

                    <td>₹ {{ number_format($visa->total_cost,2) }}</td>

                    <td class="p-4 text-right space-x-2">
                        <a href="{{ route('admin.visa-applications.show',$visa) }}"
                           class="text-blue-600">View</a>

                        <a href="{{ route('admin.visa-applications.edit',$visa) }}"
                           class="text-purple-600">Edit</a>
                    </td>

                </tr>
                @endforeach
            </tbody>

        </table>

    </div>

</div>

@endsection
