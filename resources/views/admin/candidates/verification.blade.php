@extends('admin.layouts.app')

@section('content')

<style>
.card-soft{
    background:#fff;
    border:1px solid #ece9ff;
    border-radius:14px;
    box-shadow:0 6px 18px rgba(140,120,255,0.08);
}

.table-compact td{
    padding:6px 8px;   /* reduced */
    font-size:13px;    /* reduced */
}

.badge-soft{
    padding:3px 8px;
    font-size:11px;
    border-radius:6px;
}

.btn-verify{
    background:#22c55e;
    color:#fff;
    font-size:12px;
    padding:4px 10px;
    border-radius:6px;
}

.btn-verify:hover{
    opacity:.9;
}
</style>

<h2 class="text-lg font-bold mb-4 text-purple-600">
    🪪 Candidate Verification
</h2>

@foreach($candidates as $candidate)
<div class="card-soft p-3 mb-4">

    <h3 class="font-semibold text-sm mb-2 text-gray-700">
        👤 {{ $candidate->full_name }}
        <span class="text-gray-500 text-xs">
            ({{ $candidate->passport_number }})
        </span>
    </h3>

    <table class="w-full table-compact">
        @foreach($candidate->documents as $doc)
        <tr class="border-t">

            <td class="text-gray-700">
                📄 {{ ucfirst($doc->document_type) }}
            </td>

            <td>
                <span class="badge-soft {{ $doc->status_badge_class }}">
                    {{ ucfirst($doc->verification_status) }}
                </span>
            </td>

            <td class="text-right">
                @if($doc->verification_status=='pending')
                <form method="POST"
                      action="{{ route('admin.candidate.document.verify',$doc) }}">
                    @csrf
                    <input type="hidden" name="status" value="verified">

                    <button class="btn-verify">
                        ✔ Verify
                    </button>
                </form>
                @endif
            </td>

        </tr>
        @endforeach
    </table>

</div>
@endforeach

@endsection
