@extends('admin.layouts.app')

@section('content')

<div class="max-w-7xl mx-auto mt-10">

    <!-- Header -->
    <div class="flex justify-between items-center mb-6">
        <h2 class="text-2xl font-bold text-[#9f1239] flex items-center gap-2">
            💰 Wallet Management
        </h2>
    </div>

    <!-- Summary Cards -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">

        <div class="bg-gradient-to-r from-pink-500 to-rose-500 text-white p-6 rounded-3xl shadow-xl">
            <p class="text-sm opacity-90">Total Wallets</p>
            <h3 class="text-2xl font-bold mt-2">{{ $wallets->count() }}</h3>
        </div>

        <div class="bg-gradient-to-r from-purple-500 to-indigo-500 text-white p-6 rounded-3xl shadow-xl">
            <p class="text-sm opacity-90">Total System Balance</p>
            <h3 class="text-2xl font-bold mt-2">
                ₹ {{ number_format(\App\Models\CandidateWallet::sum('balance'),2) }}
            </h3>
        </div>

        <div class="bg-gradient-to-r from-emerald-500 to-green-500 text-white p-6 rounded-3xl shadow-xl">
            <p class="text-sm opacity-90">Active Wallets</p>
            <h3 class="text-2xl font-bold mt-2">
                {{ \App\Models\CandidateWallet::where('balance','>',0)->count() }}
            </h3>
        </div>

    </div>

    <!-- Wallet Table -->
    <div class="bg-[#fff7f9] border border-[#f5d0d6] rounded-3xl shadow-xl p-6">

        <table class="datatable w-full text-left">
            <thead>
                <tr class="text-[#9f1239] border-b border-[#f5d0d6]">
                    <th class="py-3">Wallet ID</th>
                    <th>Candidate</th>
                    <th>Balance</th>
                    <th>Status</th>
                    <th class="text-center">Actions</th>
                </tr>
            </thead>

            <tbody class="text-gray-700">

                @foreach($wallets as $wallet)
                <tr class="border-b border-[#f5d0d6] hover:bg-[#ffe4e6] transition">

                    <td class="py-3 font-semibold text-[#9f1239]">
                        {{ $wallet->wallet_uid }}
                    </td>

                    <td>{{ $wallet->candidate->full_name ?? '-' }}</td>

                    <td>
                        <span class="px-3 py-1 rounded-full text-sm font-semibold
                            {{ $wallet->balance > 0
                                ? 'bg-green-100 text-green-700'
                                : 'bg-gray-100 text-gray-500' }}">
                            ₹ {{ number_format($wallet->balance,2) }}
                        </span>
                    </td>

                    <td>
                        @if($wallet->balance > 0)
                            <span class="bg-emerald-100 text-emerald-700 px-3 py-1 rounded-full text-xs">
                                Active
                            </span>
                        @else
                            <span class="bg-gray-100 text-gray-500 px-3 py-1 rounded-full text-xs">
                                Empty
                            </span>
                        @endif
                    </td>

                    <td class="text-center space-x-2">

                        <!-- Add Money -->
                        <button onclick="openCreditModal({{ $wallet->id }})"
                            class="inline-flex items-center justify-center
                                   w-9 h-9 rounded-full
                                   bg-green-100 text-green-700
                                   hover:bg-green-200 transition"
                            title="Add Amount">
                            ➕
                        </button>

                        <!-- View Wallet -->
                        <a href="{{ route('admin.wallets.show',$wallet->candidate_id) }}"
                           class="inline-flex items-center justify-center
                                  w-9 h-9 rounded-full
                                  bg-blue-100 text-blue-700
                                  hover:bg-blue-200 transition"
                           title="View Wallet">
                            👁
                        </a>

                        <!-- View Transactions -->
                        <button onclick="openTransactionModal({{ $wallet->id }})"
                            class="inline-flex items-center justify-center
                                   w-9 h-9 rounded-full
                                   bg-purple-100 text-purple-700
                                   hover:bg-purple-200 transition"
                            title="Transactions">
                            📜
                        </button>

                    </td>

                </tr>
                @endforeach

            </tbody>
        </table>

    </div>

</div>

<!-- CREDIT MODAL -->
<div id="creditModal" class="hidden fixed inset-0 bg-black bg-opacity-40 flex items-center justify-center">

    <div class="bg-white p-6 rounded-2xl w-96 shadow-xl">

        <h3 class="text-lg font-semibold mb-4 text-[#9f1239]">Add Amount</h3>

        <form method="POST" id="creditForm">
            @csrf

            <input type="number" name="amount"
                   class="w-full border rounded-lg px-3 py-2 mb-3"
                   placeholder="Enter Amount" required>

            <textarea name="description"
                      class="w-full border rounded-lg px-3 py-2 mb-4"
                      placeholder="Description"></textarea>

            <div class="flex justify-end gap-2">
                <button type="button"
                        onclick="closeCreditModal()"
                        class="px-4 py-2 border rounded-lg">
                    Cancel
                </button>

                <button class="bg-green-600 text-white px-4 py-2 rounded-lg">
                    Submit
                </button>
            </div>
        </form>

    </div>
</div>

@endsection

@push('scripts')

<script>

function openCreditModal(walletId) {
    const form = document.getElementById('creditForm');
    form.action = "/admin/wallets/" + walletId + "/transaction";
    document.getElementById('creditModal').classList.remove('hidden');
}

function closeCreditModal() {
    document.getElementById('creditModal').classList.add('hidden');
}



</script>

@endpush
