@extends('admin.layouts.app')

@section('content')

<div class="max-w-6xl mx-auto mt-8">

<div class="bg-white rounded-3xl shadow-xl overflow-hidden">

<div class="bg-gradient-to-r from-purple-500 to-indigo-500
            text-white p-8">

<h2 class="text-2xl font-bold">
{{ $employer->company_name }}
</h2>

<p>{{ $employer->company_email }}</p>

</div>

<div class="p-8 grid grid-cols-2 gap-8">

<div>
<h4 class="font-semibold text-gray-600">Industry</h4>
<p>{{ $employer->industry }}</p>
</div>

<div>
<h4 class="font-semibold text-gray-600">Company Size</h4>
<p>{{ $employer->company_size }}</p>
</div>

<div>
<h4 class="font-semibold text-gray-600">HR Contact</h4>
<p>{{ $employer->contact_person_name }}</p>
</div>

<div>
<h4 class="font-semibold text-gray-600">Wallet Balance</h4>
<p>₹ {{ $employer->calculated_wallet_balance }}</p>
</div>

<div class="col-span-2">
<h4 class="font-semibold text-gray-600">Address</h4>
<p>{{ $employer->address }}</p>
</div>

</div>

</div>

</div>

@endsection
