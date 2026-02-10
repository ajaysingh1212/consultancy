@extends('admin.layouts.app')

@section('content')

<div class="flex justify-between mb-4">
    <h2 class="text-xl font-bold">Candidates</h2>

    @can('candidate.create')
    <a href="{{ route('admin.candidates.create') }}"
       class="bg-green-600 px-4 py-2 rounded">
        Add Candidate
    </a>
    @endcan
</div>

<div class="bg-white p-4 rounded shadow">
    
<table class="datatable w-full">
    <thead>
        <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Passport</th>
            <th>KYC</th>
            <th>Actions</th>
        </tr>
    </thead>

    <tbody>
        @foreach($candidates as $candidate)
        <tr>
            <td>{{ $candidate->id }}</td>
            <td>{{ $candidate->full_name }}</td>
            <td>{{ $candidate->passport_number }}</td>
            <td>
                <span class="px-2 py-1 rounded text-xs
                    @if($candidate->kyc_status=='verified') bg-green-200
                    @elseif($candidate->kyc_status=='rejected') bg-red-200
                    @else bg-yellow-200 @endif">
                    {{ ucfirst($candidate->kyc_status) }}
                </span>
            </td>
            <td class="space-x-1">
                {{-- Edit --}}
                <a href="{{ route('admin.candidates.edit',$candidate) }}"
                class="bg-yellow-500 px-2 py-1 rounded dark">
                    Edit
                </a>

                {{-- KYC Form --}}
                <a href="{{ route('admin.candidates.kyc.show',$candidate) }}"
                class="bg-blue-600 px-2 py-1 rounded dark">
                    KYC
                </a>

                {{-- Upload Documents --}}
                <a href="{{ route('admin.candidates.documents',$candidate) }}"
                class="bg-indigo-600 px-2 py-1 rounded dark">
                    Documents
                </a>

                {{-- Delete --}}
                <form action="{{ route('admin.candidates.destroy',$candidate) }}"
                    method="POST" class="inline">
                    @csrf @method('DELETE')
                    <button class="bg-red-600 px-2 py-1 rounded dark"
                        onclick="return confirm('Delete?')">
                        Delete
                    </button>
                </form>
            </td>

        </tr>
        @endforeach
    </tbody>
</table>
</div>

@endsection
