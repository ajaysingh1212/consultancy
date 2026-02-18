@extends('admin.layouts.app')

@section('content')
@if(session('error'))
<script>
    alert("{{ session('error') }}");
</script>
@endif

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

        <table class="datatable w-full text-sm">
            <thead class="border-b">
                <tr>
                    <th>Invoice</th>
                    <th>Candidate</th>
                    <th>Categories</th>
                    <th>Amount</th>
                    <th>Status</th>
                    <th width="160">Action</th>
                </tr>
            </thead>

            <tbody>
                @foreach($expenses as $expense)
                <tr class="border-b hover:bg-gray-50">

                    <td>{{ $expense->invoice_no }}</td>

                    <td>
                        {{ $expense->wallet->candidate->full_name ?? '-' }}
                    </td>

                    <!-- ✅ CATEGORY FIX -->
                    <td>
                        {{ $expense->items->pluck('category.name')->implode(', ') }}
                    </td>

                    <td>
                        ₹ {{ number_format($expense->grand_total,2) }}
                    </td>

                    <td>
                        @if($expense->status === 'approved')
                            <span class="bg-green-100 text-green-700 px-2 py-1 rounded-full text-xs">
                                Approved
                            </span>
                        @else
                            <span class="bg-yellow-100 text-yellow-700 px-2 py-1 rounded-full text-xs">
                                Pending
                            </span>
                        @endif
                    </td>

                    <td class="space-x-2">

                        <!-- VIEW -->
                        <a href="{{ route('admin.expenses.show',$expense->id) }}"
                           class="bg-blue-100 px-3 py-1 rounded-lg">
                            👁
                        </a>

                        <!-- EDIT (only if pending) -->
                        @if($expense->status === 'pending')
                            <a href="{{ route('admin.expenses.edit',$expense->id) }}"
                               class="bg-indigo-100 px-3 py-1 rounded-lg">
                                ✏️
                            </a>
                        @endif

                        <!-- APPROVE -->
                        @can('expense.approve')
                        @if($expense->status === 'pending')
                            <button
                                onclick="openApproveModal({{ $expense->id }}, {{ $expense->grand_total }})"
                                class="bg-green-100 px-3 py-1 rounded-lg">
                                ✔
                            </button>
                        @endif
                        @endcan

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


<!-- APPROVE MODAL -->

<div id="approveModal"
     class="hidden fixed inset-0 bg-black/40 flex items-center justify-center z-50">

    <div class="bg-white rounded-2xl p-6 w-96 shadow-xl">

        <h3 class="text-lg font-semibold text-red-600 mb-4">
            Approve Expense
        </h3>

        <p class="mb-4">
            Are you sure you want to approve this expense?
        </p>

        <form method="POST" id="approveForm">
            @csrf
            <button class="bg-green-600 text-white px-4 py-2 rounded-lg">
                Yes, Approve
            </button>

            <button type="button"
                onclick="closeApproveModal()"
                class="ml-2 px-4 py-2 border rounded-lg">
                Cancel
            </button>
        </form>

    </div>
</div>

@endsection


@push('scripts')
<script>

function openApproveModal(id)
{
    const form = document.getElementById('approveForm');

    form.action = "{{ url('admin/wallets/expense/approve') }}/" + id;

    document.getElementById('approveModal').classList.remove('hidden');
}


function closeApproveModal()
{
    document.getElementById('approveModal').classList.add('hidden');
}

</script>
@endpush

