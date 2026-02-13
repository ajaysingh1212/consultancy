@extends('admin.layouts.app')

@section('content')

<div class="max-w-7xl mx-auto mt-8">

    <div class="flex justify-between mb-6">
        <h2 class="text-2xl font-bold text-indigo-600">
            🧬 Candidate Biometrics
        </h2>

        <a href="{{ route('admin.candidate-biometrics.create') }}"
           class="bg-indigo-600 text-white px-4 py-2 rounded-xl">
            ➕ Add Biometric
        </a>
    </div>

    <div class="bg-white rounded-2xl shadow p-6">

        <table class=" datatable w-full text-left">

            <thead>
                <tr class="border-b">
                    <th>ID</th>
                    <th>Candidate</th>
                    <th>Photo Status</th>
                    <th>Actions</th>
                </tr>
            </thead>

            <tbody>
                @foreach($biometrics as $bio)
                <tr class="border-b">
                    <td>#{{ $bio->id }}</td>
                    <td>{{ $bio->candidate->full_name ?? '' }}</td>
                    <td>{{ $bio->photo_status }}</td>
                    <td class="space-x-2">

                        <a href="{{ route('admin.candidate-biometrics.show',$bio) }}"
                           class="text-blue-600">View</a>

                        <a href="{{ route('admin.candidate-biometrics.edit',$bio) }}"
                           class="text-yellow-600">Edit</a>

                        <form method="POST"
                              action="{{ route('admin.candidate-biometrics.destroy',$bio) }}"
                              class="inline">
                            @csrf
                            @method('DELETE')
                            <button class="text-red-600">
                                Delete
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
