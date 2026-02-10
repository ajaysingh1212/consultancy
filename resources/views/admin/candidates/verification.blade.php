@extends('admin.layouts.app')

@section('content')
<h2 class="text-xl font-bold mb-4">Candidate Verification</h2>

@foreach($candidates as $candidate)
<div class="bg-white p-4 mb-4 rounded shadow">
    <h3 class="font-semibold mb-2">
        {{ $candidate->full_name }} ({{ $candidate->passport_number }})
    </h3>

    <table class="w-full text-sm">
        @foreach($candidate->documents as $doc)
        <tr class="border-t">
            <td>{{ ucfirst($doc->document_type) }}</td>
            <td>
                <span class="px-2 py-1 rounded {{ $doc->status_badge_class }}">
                    {{ ucfirst($doc->verification_status) }}
                </span>
            </td>
            <td>
                @if($doc->verification_status=='pending')
                <form method="POST"
                      action="{{ route('admin.candidate.document.verify',$doc) }}">
                    @csrf
                    <input type="hidden" name="status" value="verified">
                    <button class="bg-green-600 px-2 py-1 rounded">
                        Verify
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
