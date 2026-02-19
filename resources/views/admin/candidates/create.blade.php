@extends('admin.layouts.app')

@section('content')

<div class="max-w-6xl mx-auto mt-10">

    <!-- Header -->
    <div class="flex justify-between items-center mb-8">
        <h2 class="text-3xl font-bold text-[#7c3aed] flex items-center gap-3">
            🧑‍💼 Add Candidate
        </h2>

        <a href="{{ route('admin.candidates.index') }}"
           class="bg-white border border-[#ddd6fe]
                  text-[#7c3aed] px-6 py-3
                  rounded-2xl shadow-sm
                  hover:bg-[#ede9fe]
                  transition flex items-center gap-2">
            📋 View All
        </a>
    </div>

    <!-- Card -->
    <form method="POST"
          action="{{ route('admin.candidates.store') }}"
          id="candidateForm"
          class="bg-gradient-to-br from-[#f5f3ff] to-[#faf5ff]
                 border border-[#e9d5ff]
                 rounded-3xl shadow-2xl p-10">

        @csrf

        <!-- EMAIL SECTION -->
        <div class="mb-8">
            <label class="block text-lg font-semibold mb-3">
                📧 Email Address
            </label>

            <div class="flex gap-4">
                <input type="email"
                       name="email"
                       id="email"
                       required
                       placeholder="Enter candidate email"
                       class="w-full px-5 py-4 rounded-2xl border border-[#ddd6fe] focus:ring-2 focus:ring-[#7c3aed]">

                <button type="button"
                        onclick="sendOtp()"
                        id="verifyBtn"
                        class="bg-[#7c3aed] hover:bg-[#6d28d9]
                               text-white px-6 py-4 rounded-2xl shadow-md transition">
                    Verify
                </button>
            </div>

            <p id="emailVerifiedMsg"
               class="text-green-600 font-medium mt-3 hidden flex items-center gap-2">
                <span class="text-xl">✔</span> Email Successfully Verified
            </p>
        </div>

        <hr class="mb-8 border-[#e9d5ff]">

        <!-- REST FORM -->
        <div id="remainingFields"
             class="grid grid-cols-1 md:grid-cols-2 gap-6 opacity-50 pointer-events-none transition duration-300">

            <input name="full_name" placeholder="Full Name" class="p-3 rounded-xl border border-[#ddd6fe]">
            <input name="mobile" placeholder="Mobile" class="p-3 rounded-xl border border-[#ddd6fe]">
            <input name="passport_number" placeholder="Passport Number" class="p-3 rounded-xl border border-[#ddd6fe]">
            <input type="date" name="dob" class="p-3 rounded-xl border border-[#ddd6fe]">
            <input name="nationality" placeholder="Nationality" class="p-3 rounded-xl border border-[#ddd6fe]">
            <input type="date" name="passport_expiry" class="p-3 rounded-xl border border-[#ddd6fe]">

            <select name="gender" class="p-3 rounded-xl border border-[#ddd6fe]">
                <option value="">Select Gender</option>
                <option>Male</option>
                <option>Female</option>
            </select>

            <select name="marital_status" class="p-3 rounded-xl border border-[#ddd6fe]">
                <option value="">Select Status</option>
                <option>Single</option>
                <option>Married</option>
            </select>

        </div>

        <button type="submit"
                id="submitBtn"
                disabled
                class="mt-8 bg-gray-400 text-white px-8 py-3 rounded-xl transition">
            💾 Save Candidate
        </button>

    </form>
</div>

<!-- OTP MODAL -->
<div id="otpModal"
     class="fixed inset-0 bg-black bg-opacity-60 hidden flex items-center justify-center z-50">

    <div class="bg-white p-8 rounded-3xl w-[400px] shadow-2xl text-center relative">

        <h3 class="text-2xl font-bold text-[#7c3aed] mb-4">
            🔐 Email Verification
        </h3>

        <!-- Countdown -->
        <div id="countdown" class="text-red-500 font-semibold mb-2">05:00</div>

        <!-- Attempt Counter -->
        <div id="attemptCounter" class="text-sm text-gray-500 mb-4">
            Attempts Left: 5
        </div>

        <!-- OTP Inputs -->
        <div class="flex justify-center gap-2 mb-6">
            @for($i=0;$i<6;$i++)
                <input maxlength="1"
                       class="otp-input w-12 h-12 text-center text-xl border-2 border-[#ddd6fe] rounded-lg focus:border-[#7c3aed] focus:ring-2 focus:ring-[#7c3aed]"
                       oninput="moveNext(this)"
                       onkeydown="moveBack(event,this)">
            @endfor
        </div>

        <!-- Loader -->
        <div id="loader" class="hidden mb-4">
            <div class="loader mx-auto"></div>
        </div>

        <button onclick="verifyOtp()"
                class="bg-[#7c3aed] hover:bg-[#6d28d9] text-white w-full py-3 rounded-xl">
            Verify OTP
        </button>

        <button onclick="resendOtp()"
                id="resendBtn"
                class="mt-3 text-[#7c3aed] font-semibold hidden">
            Resend OTP
        </button>

        <!-- Success Animation -->
        <div id="successAnimation" class="hidden mt-6">
            <div class="checkmark-circle">
                <div class="background"></div>
                <div class="checkmark draw"></div>
            </div>
        </div>

    </div>
</div>

<!-- Toast -->
<div id="toast"
     class="fixed bottom-5 right-5 px-6 py-3 rounded-lg text-white hidden"></div>


<script>

let timer;
let timeLeft = 300;
let attemptsLeft = 5;

function showToast(message,type="success"){
    let t=document.getElementById('toast');
    t.innerText=message;
    t.classList.remove('hidden');
    t.style.background=type==="error"?"#dc2626":"#16a34a";
    setTimeout(()=>t.classList.add('hidden'),3000);
}

function moveNext(el){
    if(el.value.length===1){
        let next=el.nextElementSibling;
        if(next) next.focus();
    }
}

function moveBack(e,el){
    if(e.key==="Backspace" && el.value===""){
        let prev=el.previousElementSibling;
        if(prev) prev.focus();
    }
}

function getOtp(){
    let otp="";
    document.querySelectorAll('.otp-input').forEach(i=>otp+=i.value);
    return otp;
}

function startTimer(){
    timeLeft=300;
    attemptsLeft=5;
    document.getElementById('attemptCounter').innerText="Attempts Left: 5";
    document.getElementById('resendBtn').classList.add('hidden');

    timer=setInterval(()=>{
        let min=Math.floor(timeLeft/60);
        let sec=timeLeft%60;
        document.getElementById('countdown').innerText=
        `${String(min).padStart(2,'0')}:${String(sec).padStart(2,'0')}`;

        if(timeLeft<=0){
            clearInterval(timer);
            document.getElementById('resendBtn').classList.remove('hidden');
        }
        timeLeft--;
    },1000);
}

async function sendOtp(){
    let email=document.getElementById('email').value;
    if(!email){ showToast("Enter email first","error"); return; }

    let res=await fetch("{{ route('admin.send.otp') }}",{
        method:"POST",
        headers:{
            'X-CSRF-TOKEN':'{{ csrf_token() }}',
            'Accept':'application/json',
            'Content-Type':'application/json'
        },
        body:JSON.stringify({email:email})
    });

    let data=await res.json();

    if(data.success){
        document.getElementById('otpModal').classList.remove('hidden');
        startTimer();
        showToast("OTP Sent Successfully");
    }else{
        showToast(data.message,"error");
    }
}

async function resendOtp(){
    clearInterval(timer);
    await sendOtp();
}

async function verifyOtp(){

    document.getElementById('loader').classList.remove('hidden');

    let otp=getOtp();

    let res=await fetch("{{ route('admin.verify.otp') }}",{
        method:"POST",
        headers:{
            'X-CSRF-TOKEN':'{{ csrf_token() }}',
            'Accept':'application/json',
            'Content-Type':'application/json'
        },
        body:JSON.stringify({otp:otp})
    });

    let data=await res.json();

    document.getElementById('loader').classList.add('hidden');

    if(data.success){

        clearInterval(timer);

        document.getElementById('successAnimation').classList.remove('hidden');

        setTimeout(()=>{
            document.getElementById('otpModal').classList.add('hidden');

            document.getElementById('remainingFields')
            .classList.remove('pointer-events-none','opacity-50');

            document.getElementById('submitBtn').disabled=false;
            document.getElementById('submitBtn')
            .classList.remove('bg-gray-400');
            document.getElementById('submitBtn')
            .classList.add('bg-[#7c3aed]');

            document.getElementById('emailVerifiedMsg').classList.remove('hidden');
            document.getElementById('verifyBtn').disabled=true;
            document.getElementById('email').readOnly=true;

        },1500);

    }else{
        attemptsLeft--;
        document.getElementById('attemptCounter').innerText=
            "Attempts Left: "+attemptsLeft;

        showToast(data.message || "Invalid OTP","error");
    }
}

</script>

<style>

.loader{
    border:4px solid #f3f3f3;
    border-top:4px solid #7c3aed;
    border-radius:50%;
    width:30px;
    height:30px;
    animation:spin 1s linear infinite;
}
@keyframes spin{
    0%{transform:rotate(0deg);}
    100%{transform:rotate(360deg);}
}

.checkmark-circle{
    width:80px;
    height:80px;
    position:relative;
    display:inline-block;
}
.checkmark-circle .background{
    width:80px;
    height:80px;
    border-radius:50%;
    background:#16a34a;
}
.checkmark{
    border-radius:5px;
}
.checkmark.draw:after{
    animation:checkmark 0.6s ease forwards;
    content:'';
    position:absolute;
    left:22px;
    top:40px;
    width:25px;
    height:5px;
    background:white;
    transform:rotate(45deg);
}
@keyframes checkmark{
    from{width:0;}
    to{width:25px;}
}

</style>

@endsection
