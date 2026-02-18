@extends('admin.layouts.app')

@section('content')

<div class="max-w-7xl mx-auto mt-10">

    <!-- Header -->
    <div class="flex justify-between items-center mb-6">
        <h2 class="text-2xl font-bold text-[#9f1239] flex items-center gap-2">
            💰 Wallet Management
        </h2>

        @can('wallet.debit')
        <a href="{{ route('admin.expenses.create') }}"
           class="bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded-xl shadow">
            🧾 Record Expense
        </a>
        @endcan
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
                    <th>Wallet ID</th>
                    <th>Candidate</th>
                    <th>Balance</th>
                    <th>Deposits</th>
                    <th>Status</th>
                    <th class="text-center">Actions</th>
                </tr>
            </thead>

            <tbody class="text-gray-700">

                @foreach($wallets as $wallet)

                @php
                    $depositTxns = $wallet->transactions
                        ->where('reference_type','wallet_deposit');

                    $pending = $depositTxns->where('status','pending');
                    $approved = $depositTxns->where('status','approved');

                    $pendingTotal = $pending->sum('amount');
                    $approvedTotal = $approved->sum('amount');
                @endphp

                <tr class="border-b border-[#f5d0d6] hover:bg-[#ffe4e6] transition">

                    <td class="font-semibold text-[#9f1239]">
                        {{ $wallet->wallet_uid }}
                    </td>

                    <td>{{ $wallet->candidate->full_name ?? '-' }}</td>

                    <!-- Balance -->
                    <td>
                        <span class="px-3 py-1 rounded-full text-sm font-semibold
                            {{ $wallet->balance > 0
                                ? 'bg-green-100 text-green-700'
                                : 'bg-gray-100 text-gray-500' }}">
                            ₹ {{ number_format($wallet->balance,2) }}
                        </span>
                    </td>

                    <!-- Deposits Smart Column -->
                    <td>

                        @can('wallet.view_transactions')

                            @if($pendingTotal > 0)
                                <button onclick="openTxnModal({{ $wallet->id }}, 'pending')"
                                    class="bg-yellow-100 text-yellow-700 px-3 py-1 rounded-full text-xs mr-1">
                                    ₹ {{ number_format($pendingTotal,2) }} Pending
                                </button>
                            @endif

                            @if($approvedTotal > 0)
                                <button onclick="openTxnModal({{ $wallet->id }}, 'approved')"
                                    class="bg-green-100 text-green-700 px-3 py-1 rounded-full text-xs">
                                    ₹ {{ number_format($approvedTotal,2) }} Approved
                                </button>
                            @endif

                            @if($pendingTotal == 0 && $approvedTotal == 0)
                                -
                            @endif

                        @else
                            -
                        @endcan

                    </td>

                    <!-- Status -->
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

                    <!-- Actions -->
                    <td class="text-center space-x-2">

                        @can('wallet.credit')
                        <button onclick="openCreditModal({{ $wallet->id }})"
                            class="w-9 h-9 rounded-full bg-green-100 text-green-700 hover:bg-green-200">
                            ➕
                        </button>
                        @endcan
                        @can('wallet.view_transactions')
                            <a href="{{ route('admin.wallets.transactions',$wallet->id) }}"
                                class="w-9 h-9 inline-flex items-center justify-center
                                rounded-full bg-purple-100 text-purple-700 hover:bg-purple-200"
                                title="All Transactions"> 📊
                            </a>
                        @endcan
                        @can('wallet.credit')
                            @foreach($pending as $txn)
                            <form method="POST"
                                action="{{ route('admin.wallets.approve',$txn->id) }}"
                                class="inline">
                                @csrf
                                <button class="w-9 h-9 rounded-full bg-yellow-100 text-yellow-700 hover:bg-yellow-200"
                                    title="Approve ₹{{ $txn->amount }}">
                                    ✔
                                </button>
                            </form>
                            @endforeach
                        @endcan

                        <a href="{{ route('admin.wallets.show',$wallet->candidate_id) }}"
                        class="w-9 h-9 inline-flex items-center justify-center rounded-full bg-blue-100 text-blue-700 hover:bg-blue-200">
                            👁
                        </a>

                    </td>

                </tr>

                @endforeach

            </tbody>
        </table>

    </div>

</div>

<!-- ================= CREDIT MODAL ================= -->

<div id="creditModal"
     class="hidden fixed inset-0 bg-black bg-opacity-40 z-50 flex items-center justify-center">

    <div class="bg-white p-6 rounded-2xl w-96 shadow-xl">

        <h3 class="text-lg font-semibold mb-4 text-[#9f1239]">
            💳 Deposit Request
        </h3>

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

<!-- ================= CREATIVE TRANSACTION MODAL ================= -->

<div id="txnModal"
     class="hidden fixed inset-0 bg-black/50 backdrop-blur-sm z-50 flex items-center justify-center p-4">

    <div class="bg-white rounded-3xl shadow-2xl w-full max-w-4xl max-h-[85vh] overflow-hidden animate-fadeIn">

        <!-- Header -->
        <div class="bg-gradient-to-r from-purple-600 to-pink-500 text-white px-6 py-4 flex justify-between items-center">

            <div>
                <h3 class="text-xl font-semibold flex items-center gap-2">
                    💳 Deposit Transactions
                </h3>
                <p class="text-sm opacity-80">
                    Wallet deposit history overview
                </p>
            </div>

            <button onclick="closeTxnModal()"
                    class="bg-white/20 hover:bg-white/30 transition px-3 py-1 rounded-full">
                ✖
            </button>

        </div>

        <!-- Body -->
        <div class="p-6 overflow-y-auto max-h-[70vh]">

            <table class="w-full text-sm border-separate border-spacing-y-3">

                <thead>
                    <tr class="text-gray-500 text-xs uppercase tracking-wider">
                        <th class="text-left px-4">Date</th>
                        <th class="text-left px-4">Amount</th>
                        <th class="text-left px-4">Status</th>
                        <th class="text-left px-4">Reference ID</th>
                    </tr>
                </thead>

                <tbody id="txnBody">
                    <!-- Dynamic Rows Injected by JS -->
                </tbody>

            </table>

            <!-- Empty State -->
            <div id="txnEmpty"
                 class="hidden text-center text-gray-400 py-10">
                📭 No transactions found
            </div>

        </div>

        <!-- Footer -->
        <div class="bg-gray-50 px-6 py-3 text-right border-t">
            <button onclick="closeTxnModal()"
                class="bg-gray-200 hover:bg-gray-300 text-gray-700 px-4 py-2 rounded-xl transition">
                Close
            </button>
        </div>

    </div>
</div>


@endsection

@push('scripts')

<script>

function openCreditModal(walletId) {
    const form = document.getElementById('creditForm');
    form.action = "/admin/wallets/" + walletId + "/add-money";
    document.getElementById('creditModal').classList.remove('hidden');
}

function closeCreditModal() {
    document.getElementById('creditModal').classList.add('hidden');
}

function openTxnModal(walletId, status)
{
    fetch(`/admin/wallets/${walletId}/transactions/${status}`)
        .then(res => res.json())
        .then(data => {

            let body = document.getElementById('txnBody');
            let empty = document.getElementById('txnEmpty');

            body.innerHTML = '';

            if (data.length === 0) {
                empty.classList.remove('hidden');
            } else {
                empty.classList.add('hidden');

                data.forEach(txn => {

                    let statusBadge =
                        txn.status === 'approved'
                        ? '<span class="bg-emerald-100 text-emerald-700 px-3 py-1 rounded-full text-xs font-semibold">Approved</span>'
                        : '<span class="bg-yellow-100 text-yellow-700 px-3 py-1 rounded-full text-xs font-semibold">Pending</span>';

                    let row = `
                        <tr class="bg-white shadow-sm rounded-xl hover:shadow-md transition">
                            <td class="px-4 py-3">${txn.created_at}</td>
                            <td class="px-4 py-3 font-semibold text-purple-600">₹ ${txn.amount}</td>
                            <td class="px-4 py-3">${statusBadge}</td>
                            <td class="px-4 py-3 text-gray-500">${txn.reference_id}</td>
                        </tr>
                    `;

                    body.innerHTML += row;
                });
            }

            document.getElementById('txnModal').classList.remove('hidden');
        });
}


function closeTxnModal()
{
    document.getElementById('txnModal').classList.add('hidden');
}

</script>

@endpush
