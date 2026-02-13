@extends('admin.layouts.app')

@section('content')

<div class="max-w-5xl mx-auto mt-8">

    <h2 class="text-2xl font-bold text-indigo-600 mb-6">
        ✏ Edit Biometric
    </h2>

    <form method="POST"
          action="{{ route('admin.candidate-biometrics.update',$candidateBiometric) }}">
        @csrf
        @method('PUT')

        <div class="bg-white p-6 rounded-2xl shadow">

            <label class="block mb-2 font-semibold">
                Photo Status
            </label>

            <select name="photo_status"
                    class="w-full border p-2 rounded mb-4">
                <option value="pending"
                    {{ $candidateBiometric->photo_status=='pending'?'selected':'' }}>
                    Pending
                </option>
                <option value="captured"
                    {{ $candidateBiometric->photo_status=='captured'?'selected':'' }}>
                    Captured
                </option>
            </select>

            <button class="bg-indigo-600 text-white px-4 py-2 rounded-xl">
                Update
            </button>

        </div>

    </form>

</div>

@endsection
