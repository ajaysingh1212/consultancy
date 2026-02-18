@extends('admin.layouts.app')

@section('content')

<div class="max-w-7xl mx-auto mt-10">

    <!-- Page Title -->
    <div class="mb-8">
        <h2 class="text-3xl font-bold text-[#9f1239] flex items-center gap-3">
            📊 Wallet Ledger — {{ $wallet->wallet_uid }}
        </h2>
        <p class="text-gray-500 mt-1">
            Complete transaction history overview
        </p>
    </div>

    @php
        $totalTxn = $transactions->total();
        $totalPending = $transactions->where('status','pending')->sum('amount');
        $totalApproved = $transactions->where('status','approved')->sum('amount');
        $totalDebit = $transactions->where('type','debit')->sum('amount');
    @endphp

    <!-- ================= SUMMARY CARDS ================= -->

    <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-10">

        <!-- Total Transactions -->
        <div class="bg-gradient-to-r from-indigo-500 to-purple-600 text-white p-6 rounded-3xl shadow-xl">
            <p class="text-sm opacity-90">Total Transactions</p>
            <h3 class="text-2xl font-bold mt-2">{{ $totalTxn }}</h3>
        </div>

        <!-- Pending -->
        <div class="bg-gradient-to-r from-yellow-400 to-orange-500 text-white p-6 rounded-3xl shadow-xl">
            <p class="text-sm opacity-90">Total Pending</p>
            <h3 class="text-2xl font-bold mt-2">
                ₹ {{ number_format($totalPending,2) }}
            </h3>
        </div>

        <!-- Approved -->
        <div class="bg-gradient-to-r from-emerald-500 to-green-600 text-white p-6 rounded-3xl shadow-xl">
            <p class="text-sm opacity-90">Total Approved</p>
            <h3 class="text-2xl font-bold mt-2">
                ₹ {{ number_format($totalApproved,2) }}
            </h3>
        </div>

        <!-- Total Debit -->
        <div class="bg-gradient-to-r from-rose-500 to-red-600 text-white p-6 rounded-3xl shadow-xl">
            <p class="text-sm opacity-90">Total Debit</p>
            <h3 class="text-2xl font-bold mt-2">
                ₹ {{ number_format($totalDebit,2) }}
            </h3>
        </div>

    </div>

    <!-- ================= TRANSACTION TABLE ================= -->

    <div class="bg-white rounded-3xl shadow-2xl overflow-hidden">

        <!-- Table Header -->
        <div class="bg-gradient-to-r from-pink-600 to-purple-600 text-white px-6 py-4">
            <h3 class="text-lg font-semibold">
                💳 Transaction History
            </h3>
        </div>

        <div class="p-6 overflow-x-auto">

            <table class="datatable w-full text-sm border-separate border-spacing-y-3">

                <thead>
                    <tr class="text-gray-500 text-xs uppercase tracking-wider">
                        <th class="text-left px-4">Date</th>
                        <th class="text-left px-4">Type</th>
                        <th class="text-left px-4">Amount</th>
                        <th class="text-left px-4">Status</th>
                        <th class="text-left px-4">Reference</th>
                        <th class="text-left px-4">Admin</th>
                    </tr>
                </thead>

                <tbody>

                    @forelse($transactions as $txn)

                    <tr class="bg-gray-50 hover:bg-gray-100 transition shadow-sm rounded-xl">

                        <td class="px-4 py-3">
                            {{ $txn->created_at->format('d M Y H:i') }}
                        </td>

                        <td class="px-4 py-3">
                            @if($txn->type === 'credit')
                                <span class="bg-green-100 text-green-700 px-3 py-1 rounded-full text-xs font-semibold">
                                    Credit
                                </span>
                            @else
                                <span class="bg-red-100 text-red-700 px-3 py-1 rounded-full text-xs font-semibold">
                                    Debit
                                </span>
                            @endif
                        </td>

                        <td class="px-4 py-3 font-semibold text-purple-700">
                            ₹ {{ number_format($txn->amount,2) }}
                        </td>

                        <td class="px-4 py-3">
                            @if($txn->status === 'approved')
                                <span class="bg-emerald-100 text-emerald-700 px-3 py-1 rounded-full text-xs font-semibold">
                                    Approved
                                </span>
                            @else
                                <span class="bg-yellow-100 text-yellow-700 px-3 py-1 rounded-full text-xs font-semibold">
                                    Pending
                                </span>
                            @endif
                        </td>

                        <td class="px-4 py-3 text-gray-500">
                            {{ $txn->reference_id }}
                        </td>

                        <td class="px-4 py-3 text-gray-600">
                            {{ $txn->admin->name ?? '-' }}
                        </td>

                    </tr>

                    @empty

                    <tr>
                        <td colspan="6" class="text-center py-10 text-gray-400">
                            📭 No transactions found
                        </td>
                    </tr>

                    @endforelse

                </tbody>

            </table>

        </div>

        <!-- Pagination -->
        <div class="px-6 pb-6">
            {{ $transactions->links() }}
        </div>

    </div>

</div>

@endsection
