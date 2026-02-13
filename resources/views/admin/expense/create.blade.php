@extends('admin.layouts.app')

@section('content')

<div class="max-w-7xl mx-auto mt-10">

    <h2 class="text-3xl font-bold text-[#9f1239] mb-8 flex items-center gap-3">
        🧾 Create Expense Voucher
    </h2>
    @if ($errors->any())
    <div class="bg-red-100 text-red-700 p-4 rounded-xl mb-6">
        <ul>
            @foreach ($errors->all() as $error)
                <li>• {{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    @if(session('error'))
        <div class="bg-red-100 text-red-700 p-4 rounded-xl mb-6">
            {{ session('error') }}
        </div>
    @endif

    @if(session('success'))
        <div class="bg-green-100 text-green-700 p-4 rounded-xl mb-6">
            {{ session('success') }}
        </div>
    @endif

    <div class="bg-white rounded-3xl shadow-2xl p-8 border border-gray-100">

        <form method="POST"
              action="{{ route('admin.wallets.expense.store') }}"
              enctype="multipart/form-data"
              id="expenseForm">
            @csrf

            <!-- ================= HEADER SECTION ================= -->

            <div class="grid md:grid-cols-4 gap-6 mb-8">

                <!-- Wallet -->
                <div>
                    <label class="font-semibold text-gray-600">Select Wallet</label>
                    <select name="wallet_id"
                        id="walletSelect"
                        class="w-full border rounded-xl px-4 py-3 mt-2"
                        required>

                        <option value="">Choose Candidate Wallet</option>

                        @foreach($wallets as $wallet)
                            <option value="{{ $wallet->id }}"
                                data-balance="{{ $wallet->balance }}"
                                data-name="{{ $wallet->candidate->full_name }}"
                                data-email="{{ $wallet->candidate->email }}">
                                {{ $wallet->candidate->full_name }}
                                (₹ {{ number_format($wallet->balance,2) }})
                            </option>
                        @endforeach

                    </select>
                </div>

                <!-- Date -->
                <div>
                    <label class="font-semibold text-gray-600">Date</label>
                    <input type="date"
                        name="expense_date"
                        id="expenseDate"
                        class="w-full border rounded-xl px-4 py-3 mt-2">
                </div>

                <!-- Invoice -->
                <div>
                    <label class="font-semibold text-gray-600">Invoice No</label>
                    <input type="text"
                        name="invoice_no"
                        id="invoiceNo"
                        readonly
                        class="w-full border rounded-xl px-4 py-3 mt-2 bg-gray-100">
                </div>

                <!-- Status -->
                <div>
                    <label class="font-semibold text-gray-600">Approval</label>
                    <select name="status"
                        class="w-full border rounded-xl px-4 py-3 mt-2">
                        <option value="pending">Pending</option>
                        <option value="approved">Approved</option>
                    </select>
                </div>

            </div>

            <!-- Wallet Info -->
            <div id="walletDetails"
                 class="hidden bg-gradient-to-r from-indigo-50 to-purple-50 p-4 rounded-xl mb-8 border">

                <div class="grid md:grid-cols-3 gap-4 text-sm">
                    <p><strong>Candidate:</strong> <span id="candidateName"></span></p>
                    <p><strong>Email:</strong> <span id="candidateEmail"></span></p>
                    <p><strong>Available Balance:</strong> ₹ <span id="walletBalance"></span></p>
                </div>

            </div>

            <!-- ================= EXPENSE TABLE ================= -->

            <div class="grid md:grid-cols-4 gap-6">

                <div class="md:col-span-3">

                    <table class="w-full text-sm border rounded-xl overflow-hidden">

                        <thead class="bg-gray-100 text-gray-600">
                            <tr>
                                <th class="p-3">Category</th>
                                <th class="p-3">Description</th>
                                <th class="p-3">Amount</th>
                                <th class="p-3">Taxable?</th>
                                <th class="p-3">GST %</th>
                                <th class="p-3">Tax Amt</th>
                                <th class="p-3">Total</th>
                                <th class="p-3">Action</th>
                            </tr>
                        </thead>

                        <tbody id="expenseRows">

                            <tr class="expense-row border-b">

                                <td class="p-2">
                                    <select name="category[]"
                                        class="border rounded-lg px-2 py-2 w-full">
                                        @foreach($categories as $category)
                                            <option value="{{ $category->id }}">
                                                {{ $category->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </td>

                                <td class="p-2">
                                    <input type="text"
                                        name="description[]"
                                        class="border rounded-lg px-2 py-2 w-full"
                                        required>
                                </td>

                                <td class="p-2">
                                    <input type="number"
                                        name="amount[]"
                                        class="border rounded-lg px-2 py-2 w-full amount"
                                        step="0.01"
                                        required>
                                </td>

                                <td class="p-2 text-center">
                                    <select class="border rounded-lg px-2 py-2 taxable" name="taxable[]">
                                        <option value="no">No</option>
                                        <option value="yes">Yes</option>
                                    </select>
                                </td>

                                <td class="p-2">
                                    <input type="number"
                                        name="gst_percent[]"
                                        class="border rounded-lg px-2 py-2 w-full gst hidden"
                                        step="0.01">
                                </td>

                                <td class="p-2">
                                    <input type="text"
                                        class="border rounded-lg px-2 py-2 w-full tax-amount bg-gray-100"
                                        readonly name="tax_amount[]">
                                </td>

                                <td class="p-2">
                                    <input type="text"
                                        name="row_total[]"
                                        class="border rounded-lg px-2 py-2 w-full row-total bg-gray-100"
                                        readonly>
                                </td>

                                <td class="p-2 text-center">
                                    <button type="button"
                                        class="removeRow text-red-600">✖</button>
                                </td>

                            </tr>

                        </tbody>

                    </table>

                    <button type="button"
                        id="addRow"
                        class="bg-indigo-600 text-white px-4 py-2 rounded-lg mt-4">
                        ➕ Add Row
                    </button>

                </div>

                <!-- RIGHT SIDE SUMMARY -->
                <div class="bg-gray-50 rounded-xl p-6 shadow-inner">

                    <h3 class="font-semibold text-lg mb-4 text-[#9f1239]">
                        💰 Summary
                    </h3>

                    <div class="flex justify-between mb-2">
                        <span>Total Tax</span>
                        <span>₹ <span id="totalTax">0.00</span></span>
                    </div>

                    <div class="flex justify-between text-lg font-semibold">
                        <span>Grand Total</span>
                        <span>₹ <span id="grandTotal">0.00</span></span>
                    </div>

                    <p id="balanceError"
                       class="text-red-600 hidden mt-3 text-sm">
                       ⚠ Expense exceeds wallet balance
                    </p>

                    <!-- Hidden Fields -->
                    <input type="hidden" name="sub_total" id="subTotalInput">
                    <input type="hidden" name="cgst" id="cgstInput">
                    <input type="hidden" name="sgst" id="sgstInput">
                    <input type="hidden" name="total_tax" id="totalTaxInput">
                    <input type="hidden" name="grand_total" id="grandTotalInput">

                </div>

            </div>

            <!-- Attachment -->
            <div class="mt-8">
                <label class="font-semibold text-gray-600">Attachment</label>
                <input type="file"
                    name="attachment"
                    class="w-full border rounded-xl px-4 py-3 mt-2">
            </div>

            <!-- Remarks -->
            <div class="mt-6">
                <label class="font-semibold text-gray-600">Remarks</label>
                <textarea name="remarks"
                    class="w-full border rounded-xl px-4 py-3 mt-2"></textarea>
            </div>

            <button class="bg-red-600 hover:bg-red-700 text-white px-6 py-3 rounded-xl shadow mt-6">
                Save Expense
            </button>

        </form>

    </div>

</div>

@endsection

@push('scripts')
<script>

document.addEventListener('DOMContentLoaded', function(){

    const walletSelect = document.getElementById('walletSelect');
    const invoiceNo = document.getElementById('invoiceNo');
    const expenseDate = document.getElementById('expenseDate');

    expenseDate.value = new Date().toISOString().split('T')[0];
    invoiceNo.value = "INV-" + Date.now().toString().slice(-6);

    let walletBalance = 0;

    walletSelect.addEventListener('change', function(){
        const option = this.options[this.selectedIndex];
        walletBalance = parseFloat(option.dataset.balance || 0);

        document.getElementById('candidateName').innerText = option.dataset.name || '';
        document.getElementById('candidateEmail').innerText = option.dataset.email || '';
        document.getElementById('walletBalance').innerText = walletBalance.toFixed(2);
        document.getElementById('walletDetails').classList.remove('hidden');
    });

    function calculateTotals(){

        let subTotal = 0;
        let totalTax = 0;
        let grandTotal = 0;
        let totalCGST = 0;
        let totalSGST = 0;

        document.querySelectorAll('.expense-row').forEach(row => {

            let amount = parseFloat(row.querySelector('.amount').value) || 0;
            let taxable = row.querySelector('.taxable').value;
            let gstInput = row.querySelector('.gst');
            let gstPercent = parseFloat(gstInput.value) || 0;

            let tax = 0;

            if(taxable === 'yes'){
                gstInput.classList.remove('hidden');
                tax = (amount * gstPercent) / 100;
            } else {
                gstInput.classList.add('hidden');
                gstInput.value = '';
            }

            let total = amount + tax;

            row.querySelector('.tax-amount').value = tax.toFixed(2);
            row.querySelector('.row-total').value = total.toFixed(2);

            subTotal += amount;
            totalTax += tax;
            grandTotal += total;
            totalCGST += tax / 2;
            totalSGST += tax / 2;
        });

        document.getElementById('totalTax').innerText = totalTax.toFixed(2);
        document.getElementById('grandTotal').innerText = grandTotal.toFixed(2);

        document.getElementById('subTotalInput').value = subTotal.toFixed(2);
        document.getElementById('cgstInput').value = totalCGST.toFixed(2);
        document.getElementById('sgstInput').value = totalSGST.toFixed(2);
        document.getElementById('totalTaxInput').value = totalTax.toFixed(2);
        document.getElementById('grandTotalInput').value = grandTotal.toFixed(2);

        if(grandTotal > walletBalance){
            document.getElementById('balanceError').classList.remove('hidden');
        } else {
            document.getElementById('balanceError').classList.add('hidden');
        }
    }

    document.addEventListener('input', calculateTotals);

    document.getElementById('addRow').addEventListener('click', function(){
        let firstRow = document.querySelector('.expense-row');
        let clone = firstRow.cloneNode(true);
        clone.querySelectorAll('input').forEach(i => i.value = '');
        clone.querySelector('.gst').classList.add('hidden');
        document.getElementById('expenseRows').appendChild(clone);
    });

    document.addEventListener('click', function(e){
        if(e.target.classList.contains('removeRow')){
            e.target.closest('tr').remove();
            calculateTotals();
        }
    });

});

</script>
@endpush
