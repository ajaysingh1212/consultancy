@extends('admin.layouts.app')

@section('content')

@php
$themes = [
    'sky'     => '#e0f2fe',
    'lavender'=> '#ede9fe',
    'mint'    => '#d1fae5',
    'rose'    => '#ffe4e6',
    'peach'   => '#ffedd5',
    'aqua'    => '#ccfbf1',
    'ice'     => '#eef2ff',
    'blush'   => '#fce7f3',
    'smoke'   => '#f3f4f6',
    'cream'   => '#fef9c3',
];
@endphp

<div class="invoice-wrapper">

    <!-- THEME + PRINT -->
    <div class="theme-switcher no-print">
        <label>Select Theme:</label>
        <select id="themeSelect">
            @foreach($themes as $key => $color)
                <option value="{{ $color }}">{{ ucfirst($key) }}</option>
            @endforeach
        </select>

        <button onclick="window.print()" class="print-btn-top">
            🖨 Print Invoice
        </button>
    </div>

    <div class="invoice-box" id="invoiceArea">

        @if($expense->status === 'pending')
            <div class="watermark">PENDING</div>
        @endif

        <!-- HEADER -->
        <div class="invoice-header theme-bg">

            <div>
                <img src="{{ asset('logo.png') }}" class="logo">
                <h2><b>EEMOT OVERSEAS RECRUITMENT</b></h2>
                <p>Wallet Expense Invoice</p>
            </div>

            <div class="header-right">
                <p><strong>Date:</strong> {{ \Carbon\Carbon::parse($expense->expense_date)->format('d M Y') }}</p>
                <p><strong>Invoice #:</strong> {{ $expense->invoice_no }}</p>
                <p><strong>Status:</strong> {{ ucfirst($expense->status) }}</p>
            </div>

        </div>

        <!-- BILL INFO -->
        <div class="invoice-info">

            <div>
                <h4>Supplier</h4>
                <p>EEMOT OVERSEAS RECRUITMENT   </p>
                <p>GST: 10AQFPK9218D2Z9</p>
                <p>support@eemotoverseas.com</p>
                <p>LB PLACE KADAMKUAN ROAD NH30 ,PATNA,BIHAR 800001</p>
            </div>

            <div>
                <h4>Bill To</h4>
                <p><strong>{{ $expense->wallet->candidate->full_name }}</strong></p>
                <p>Email: {{ $expense->wallet->candidate->email }}</p>
                <p>Wallet ID: {{ $expense->wallet->wallet_uid }}</p>
               @if($expense->wallet->candidate->presentAddress)
                    <p>
                        {{ $expense->wallet->candidate->presentAddress->address }}
                    </p>
                @endif
                @if($expense->wallet->candidate->permanentAddress)
                    <p>
                        <strong>Permanent Address:</strong><br>
                        {{ $expense->wallet->candidate->permanentAddress->address }}
                    </p>
                @endif


            </div>

        </div>

        <!-- TABLE -->
        <table class="invoice-table">
            <thead class="theme-bg">
                <tr>
                    <th>#</th>
                    <th>Category</th>
                    <th>Description</th>
                    <th>Amount</th>
                    <th>GST %</th>
                    <th>Tax</th>
                    <th>Total</th>
                </tr>
            </thead>

            <tbody>
                @foreach($expense->items as $index => $item)
                <tr>
                    <td>{{ $index+1 }}</td>
                    <td>{{ $item->category->name ?? '-' }}</td>
                    <td>{{ $item->description }}</td>
                    <td>₹ {{ number_format($item->amount,2) }}</td>
                    <td>{{ $item->gst_percent }}%</td>
                    <td>₹ {{ number_format($item->tax_amount,2) }}</td>
                    <td>₹ {{ number_format($item->row_total,2) }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>

        <!-- TOTAL + DISCLAIMER -->
        <div class="bottom-section">

            <div class="disclaimer theme-border theme-soft-bg">
                <h4>Disclaimer</h4>
                <ol>
                    <li>This consultancy firm acts solely as a job placement facilitator.</li>
                    <li>We do not guarantee job placement or visa approval.</li>
                    <li>All international job opportunities are subject to employer terms.</li>
                    <li>Candidate is responsible for document authenticity.</li>
                    <li>Visa approvals are handled by respective authorities.</li>
                    <li>Service fees once paid are non-refundable unless stated.</li>
                    <li>We are not liable for employer contract changes abroad.</li>
                    <li>All disputes are subject to local jurisdiction laws.</li>
                </ol>
            </div>

            <div class="totals">
                <p>Sub Total: ₹ {{ number_format($expense->sub_total,2) }}</p>
                <p>Total Tax: ₹ {{ number_format($expense->total_tax,2) }}</p>
                <p class="grand theme-bg">
                    Grand Total: ₹ {{ number_format($expense->grand_total,2) }}
                </p>
            </div>

        </div>

        <!-- FOOTER -->
        <div class="invoice-footer theme-bg">

            <div>
                {!! QrCode::size(100)->generate(route('admin.expenses.show',$expense->id)) !!}
                <small>Scan to verify invoice</small>
            </div>

            <div>
                <img src="{{ asset('storage/settings/signature.png') }}" class="sign-img">
                <p>Digitally Signed</p>
            </div>

        </div>

    </div>
</div>

@endsection
<style>

:root{
    --theme-color:#e0f2fe;
}

/* A4 */
@page{ size:A4; margin:0; }

body{
    margin:0;
    padding:0;
    background:#f3f4f6;
}

.invoice-wrapper{ padding:0; }

.invoice-box{
    width:210mm;
    min-height:297mm;
    margin:auto;
    background:white;
    display:flex;
    flex-direction:column;
    position:relative;
}

/* THEME */
.theme-bg{ background:var(--theme-color); }
.theme-border{ border:2px solid var(--theme-color); }
.theme-soft-bg{ background:rgba(0,0,0,0.02); }

/* HEADER */
.invoice-header{
    padding:25px;
    display:flex;
    justify-content:space-between;
}

.logo{ height:55px; }

/* INFO */
.invoice-info{
    padding:30px;
    display:flex;
    justify-content:space-between;
}

/* TABLE */
.invoice-table{
    width:100%;
    border-collapse:collapse;
}

.invoice-table th{
    padding:10px;
    font-weight:600;
}

.invoice-table td{
    padding:10px;
    border-bottom:1px solid #ddd;
}

/* BOTTOM SECTION */
.bottom-section{
    display:flex;
    justify-content:space-between;
    padding:30px;
    margin-top:auto;
}

.disclaimer{
    width:60%;
    padding:15px;
    border-radius:8px;
    font-size:13px;
}

.disclaimer h4{
    margin-bottom:10px;
}

.totals{
    width:30%;
    font-weight:500;
}

.grand{
    padding:10px;
    border-radius:6px;
}

/* FOOTER */
.invoice-footer{
    padding:25px;
    display:flex;
    justify-content:space-between;
}

/* WATERMARK */
.watermark{
    position:absolute;
    top:40%;
    left:20%;
    font-size:90px;
    opacity:0.05;
    transform:rotate(-30deg);
}

/* SWITCHER */
.theme-switcher{
    text-align:center;
    padding:15px;
}

.print-btn-top{
    padding:8px 15px;
    background:black;
    color:white;
    border:none;
    margin-left:10px;
    cursor:pointer;
}

/* PRINT */
@media print{
    body *{ visibility:hidden; }
    .invoice-box,.invoice-box *{ visibility:visible; }
    .invoice-box{ position:absolute; left:0; top:0; }
    .no-print{ display:none; }
}

</style>
<script>
document.addEventListener("DOMContentLoaded", function () {

    const themeSelect = document.getElementById("themeSelect");

    function applyTheme(color){
        document.documentElement.style.setProperty('--theme-color', color);
    }

    if(themeSelect){

        // Apply default selected theme on load
        applyTheme(themeSelect.value);

        themeSelect.addEventListener("change", function(){
            applyTheme(this.value);
        });
    }

});
</script>
