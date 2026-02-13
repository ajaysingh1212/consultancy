@extends('admin.layouts.app')

@section('content')

<div class="max-w-7xl mx-auto mt-10">

    <div class="flex justify-between items-center mb-6">
        <h2 class="text-2xl font-bold text-red-600">
            🧾 All Expenses
        </h2>

        @can('expense.create')
        <a href="{{ route('admin.expenses.create') }}"
           class="bg-red-600 text-white px-5 py-2 rounded-xl shadow">
            ➕ New Expense
        </a>
        @endcan
    </div>

    <div class="bg-white rounded-3xl shadow-xl p-6">

        <table class=" datatable w-full text-sm">
            <thead class="border-b">
                <tr>
                    <th>Invoice</th>
                    <th>Candidate</th>
                    <th>Category</th>
                    <th>Amount</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>
            </thead>

            <tbody>
                @foreach($expenses as $expense)
                <tr class="border-b hover:bg-gray-50">

                    <td>{{ $expense->invoice_no }}</td>
                    <td>{{ $expense->wallet->candidate->full_name }}</td>
                    <td>{{ $expense->category->name ?? '-' }}</td>
                    <td>₹ {{ number_format($expense->grand_total,2) }}</td>

                    <td>
                        <span class="bg-yellow-100 text-yellow-700 px-2 py-1 rounded-full text-xs">
                            {{ ucfirst($expense->status) }}
                        </span>
                    </td>

                    <td>
                        <a href="{{ route('admin.expenses.show',$expense) }}"
                           class="bg-blue-100 px-3 py-1 rounded-lg">👁</a>
                    </td>

                </tr>
                @endforeach
            </tbody>

        </table>

        <div class="mt-4">
            {{ $expenses->links() }}
        </div>

    </div>

</div>

@endsection
