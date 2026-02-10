@extends('admin.layouts.app')

@section('content')
<h2 class="text-xl font-bold mb-4">Add Candidate</h2>

<form method="POST" action="{{ route('admin.candidates.store') }}"
      class="bg-white p-6 rounded shadow grid grid-cols-2 gap-4">
    @csrf

    <input name="full_name" placeholder="Full Name" class="border p-2">
    <input name="mobile" placeholder="Mobile" class="border p-2">
    <input name="passport_number" placeholder="Passport No" class="border p-2">
    <input type="date" name="dob" class="border p-2">
    <input name="nationality" placeholder="Nationality" class="border p-2">
    <input type="date" name="passport_expiry" class="border p-2">

    <select name="gender" class="border p-2">
        <option>Male</option><option>Female</option>
    </select>

    <select name="marital_status" class="border p-2">
        <option>Single</option><option>Married</option>
    </select>

    <div class="col-span-2">
        <button class="bg-green-600 px-4 py-2 rounded">
            Save
        </button>
    </div>
</form>
@endsection
