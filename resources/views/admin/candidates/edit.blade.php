@extends('admin.layouts.app')

@section('content')

<style>
/* ===== Lavender + Ice White Theme ===== */

.bg-lavender {
    background: linear-gradient(135deg,#f6f3ff,#ffffff);
}

.card-soft {
    background:#ffffff;
    border:1px solid #ece9ff;
    border-radius:18px;
    box-shadow:0 10px 30px rgba(140,120,255,0.08);
    transition:.3s ease;
}
.card-soft:hover{
    transform:translateY(-4px);
    box-shadow:0 15px 40px rgba(140,120,255,0.15);
}

.lavender-text{ color:#6d5dfc; }

.lavender-btn{
    background:linear-gradient(90deg,#8f84ff,#6d5dfc);
    color:#fff;
}
.lavender-btn:hover{
    opacity:.9;
}

.input-soft{
    border:1px solid #ddd6fe;
    border-radius:10px;
    padding:10px;
    width:100%;
}
.input-soft:focus{
    outline:none;
    border-color:#8b5cf6;
    box-shadow:0 0 0 3px rgba(139,92,246,0.2);
}
</style>

<div class="bg-lavender p-6 rounded-2xl space-y-6">

    {{-- HEADER --}}
    <div class="flex items-center justify-between">
        <h2 class="text-2xl font-bold lavender-text flex items-center gap-2">
            ✏ Edit Candidate – {{ $candidate->full_name }}
        </h2>
    </div>

    @if($candidate->kyc_status === 'verified')
    <div class="bg-red-100 text-red-700 p-4 rounded-xl shadow flex items-center gap-2">
        🚫 Candidate is verified. Editing disabled.
    </div>
    @endif

    <form method="POST"
          action="{{ route('admin.candidates.update',$candidate) }}">
    @csrf
    @method('PUT')

    <fieldset {{ $candidate->kyc_status === 'verified' ? 'disabled' : '' }}
              class="space-y-6">

        {{-- ================= BASIC DETAILS ================= --}}
        <div class="card-soft p-6">
            <h3 class="font-semibold mb-4 lavender-text flex items-center gap-2">
                👤 Basic Details
            </h3>

            <label class="text-sm text-gray-600">Full Name</label>
            <input name="full_name"
                   value="{{ $candidate->full_name }}"
                   class="input-soft mt-1">
        </div>


        {{-- ================= ADDRESS ================= --}}
        <div class="card-soft p-6">
            <h3 class="font-semibold mb-4 lavender-text flex items-center gap-2">
                📍 Addresses
            </h3>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-sm">
                @foreach($candidate->addresses as $addr)
                <div class="bg-purple-50 p-4 rounded-xl border border-purple-100">
                    🏠 {{ $addr->full_address }}
                </div>
                @endforeach
            </div>
        </div>


        {{-- ================= EDUCATION (GRID DIVIDED) ================= --}}
        <div class="card-soft p-6">
            <h3 class="font-semibold mb-4 lavender-text flex items-center gap-2">
                🎓 Education
            </h3>

            <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-4">

                @foreach($candidate->educations as $edu)
                <div class="bg-purple-50 p-4 rounded-xl border border-purple-100">

                    <div class="font-semibold text-sm">
                        📘 {{ $edu->level }}
                    </div>

                    <div class="text-xs text-gray-600 mt-1">
                        {{ $edu->board_university }}
                    </div>

                    <div class="mt-3 text-[11px] px-2 py-1 rounded-full inline-block
                        @if($edu->verification_status=='verified')
                            bg-green-100 text-green-700
                        @elseif($edu->verification_status=='rejected')
                            bg-red-100 text-red-700
                        @else
                            bg-yellow-100 text-yellow-700
                        @endif
                    ">
                        @if($edu->verification_status=='verified') ✔
                        @elseif($edu->verification_status=='rejected') ✖
                        @else ⏳ @endif
                        {{ ucfirst($edu->verification_status) }}
                    </div>

                </div>
                @endforeach

            </div>
        </div>


        {{-- ================= DOCUMENTS (GRID DIVIDED) ================= --}}
        <div class="card-soft p-6">
            <h3 class="font-semibold mb-4 lavender-text flex items-center gap-2">
                📄 Documents
            </h3>

            <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-4 gap-4">

                @foreach($candidate->documents as $doc)
                <div class="bg-purple-50 p-4 rounded-xl border border-purple-100">

                    <div class="font-semibold text-sm">
                        📑 {{ ucfirst($doc->document_type) }}
                    </div>

                    <div class="mt-3 text-[11px] px-2 py-1 rounded-full inline-block
                        @if($doc->verification_status=='verified')
                            bg-green-100 text-green-700
                        @elseif($doc->verification_status=='rejected')
                            bg-red-100 text-red-700
                        @else
                            bg-yellow-100 text-yellow-700
                        @endif
                    ">
                        @if($doc->verification_status=='verified') ✔
                        @elseif($doc->verification_status=='rejected') ✖
                        @else ⏳ @endif
                        {{ ucfirst($doc->verification_status) }}
                    </div>

                </div>
                @endforeach

            </div>
        </div>


        {{-- ================= SUBMIT ================= --}}
        <div class="text-right">
            <button class="lavender-btn px-6 py-3 rounded-xl shadow-lg">
                💾 Update Candidate
            </button>
        </div>

    </fieldset>
    </form>

</div>

@endsection
