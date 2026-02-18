@extends('admin.layouts.app')

@section('content')

<style>
.action-btn{
    position: relative;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    width: 70px;
    height: 36px;
    border-radius: 9999px;
    font-weight: 600;
    transition: all 0.25s ease;
    overflow: hidden;
}

.action-btn span{
    position: absolute;
    transition: opacity 0.2s ease;
}
</style>

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
       class="action-btn bg-yellow-100 text-yellow-600 hover:bg-yellow-200"
       data-text="Edit">
        ✏
    </a>

    {{-- KYC --}}
    <a href="{{ route('admin.candidates.kyc.show',$candidate) }}"
       class="action-btn bg-blue-100 text-blue-600 hover:bg-blue-200"
       data-text="KYC">
        🛂
    </a>

    {{-- Documents --}}
    <a href="{{ route('admin.candidates.documents',$candidate) }}"
       class="action-btn bg-gray-500 text-gray-600 hover:bg-gray-100"
       data-text="Docs">
        📄
    </a>

    {{-- Profile --}}
    <a href="{{ route('admin.candidates.profile',$candidate) }}"
       class="action-btn bg-purple-100 text-purple-600 hover:bg-purple-200"
       data-text="Profile">
        👤
    </a>

    {{-- Delete --}}
    <form action="{{ route('admin.candidates.destroy',$candidate) }}"
          method="POST"
          class="inline">
        @csrf
        @method('DELETE')

        <button type="submit"
                onclick="return confirm('Delete this candidate?')"
                class="action-btn bg-red-100 text-red-600 hover:bg-red-200"
                data-text="Delete">
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
<script>
document.querySelectorAll('.action-btn').forEach(btn => {

    const original = btn.innerHTML;
    const text = btn.getAttribute('data-text');

    btn.addEventListener('mouseenter', function() {
        btn.innerHTML = text;
    });

    btn.addEventListener('mouseleave', function() {
        btn.innerHTML = original;
    });

});
</script>


@endsection
