@extends('admin.layouts.app')

@section('content')

<div class="max-w-7xl mx-auto mt-8">

    {{-- ================= HEADER ================= --}}
    <div class="flex justify-between items-center mb-6">
        <h2 class="text-2xl font-bold text-[#8b5cf6] flex items-center gap-2">
            👤 Candidates
        </h2>

        @can('candidate.create')
        <a href="{{ route('admin.candidates.create') }}"
           class="bg-[#8b5cf6] hover:bg-[#7c3aed]
                  text-white px-5 py-2.5
                  rounded-xl shadow-md
                  transition flex items-center gap-2">
            ➕ Add Candidate
        </a>
        @endcan
    </div>


    {{-- ================= CARD ================= --}}
    <div class="bg-[#f8f7ff] border border-[#e9e7ff]
                rounded-3xl shadow-lg p-6">

        {{-- DataTable buttons (CSV, Excel, PDF, Print auto load via JS) --}}
        <table class="datatable w-full text-left">

            <thead>
                <tr class="text-[#8b5cf6] border-b border-[#e9e7ff]">
                    <th class="py-3">#ID</th>
                    <th>Name</th>
                    <th>Passport</th>
                    <th>KYC Status</th>
                    <th class="text-center">Actions</th>
                </tr>
            </thead>

            <tbody class="text-gray-700">

                @foreach($candidates as $candidate)

                <tr class="border-b border-[#e9e7ff]
                           hover:bg-[#ede9fe] transition">

                    {{-- ID --}}
                    <td class="py-3 font-medium">
                        #{{ $candidate->id }}
                    </td>

                    {{-- Name --}}
                    <td class="font-semibold">
                        {{ $candidate->full_name }}
                    </td>

                    {{-- Passport --}}
                    <td>
                        <span class="bg-white border border-[#e9e7ff]
                                     px-3 py-1 rounded-full text-sm">
                            {{ $candidate->passport_number }}
                        </span>
                    </td>

                    {{-- KYC STATUS --}}
                    <td>
                        @if($candidate->kyc_status=='verified')
                            <span class="bg-green-100 text-green-700
                                         px-3 py-1 rounded-full text-xs font-semibold">
                                ✔ Verified
                            </span>
                        @elseif($candidate->kyc_status=='rejected')
                            <span class="bg-red-100 text-red-700
                                         px-3 py-1 rounded-full text-xs font-semibold">
                                ✖ Rejected
                            </span>
                        @else
                            <span class="bg-yellow-100 text-yellow-700
                                         px-3 py-1 rounded-full text-xs font-semibold">
                                ⏳ Pending
                            </span>
                        @endif
                    </td>

                    {{-- ACTIONS --}}
                   <td class="text-center space-x-2">

    {{-- Edit --}}
    <a href="{{ route('admin.candidates.edit',$candidate) }}"
       class="inline-flex items-center justify-center
              w-9 h-9 rounded-full
              bg-yellow-100 text-yellow-600
              hover:bg-yellow-200
              transition shadow-sm"
       title="Edit">
        ✏
    </a>

    {{-- KYC --}}
    <a href="{{ route('admin.candidates.kyc.show',$candidate) }}"
       class="inline-flex items-center justify-center
              w-9 h-9 rounded-full
              bg-blue-100 text-blue-600
              hover:bg-yellow-200
              transition shadow-sm"
       title="KYC">
        🛂
    </a>

    {{-- Documents --}}
    <a href="{{ route('admin.candidates.documents',$candidate) }}"
       class="inline-flex items-center justify-center
              w-9 h-9 rounded-full
              bg-gray-500 text-gray-600
              hover:bg-gray-800
              transition shadow-sm"
       title="Documents">
        📄
    </a>

    {{-- Profile --}}
    <a href="{{ route('admin.candidates.profile',$candidate) }}"
       class="inline-flex items-center justify-center
              w-9 h-9 rounded-full
              bg-purple-200 text-purple-200
              hover:bg-gray-800
              transition shadow-sm"
       title="Profile">
        👁
    </a>

    {{-- Delete --}}
    <form action="{{ route('admin.candidates.destroy',$candidate) }}"
          method="POST"
          class="inline">
        @csrf
        @method('DELETE')

        <button type="submit"
                onclick="return confirm('Delete this candidate?')"
                class="inline-flex items-center justify-center
                       w-9 h-9 rounded-full
                       bg-red-100 text-red-600
                       hover:bg-red-200
                       transition shadow-sm"
                title="Delete">
            🗑
        </button>
    </form>

</td>


                </tr>

                @endforeach

            </tbody>

        </table>

    </div>

</div>

@endsection
