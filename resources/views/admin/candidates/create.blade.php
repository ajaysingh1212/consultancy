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
                        onclick="sendOtp(false)"
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
     class="fixed inset-0 bg-black bg-opacity-60 hidden z-50 flex items-center justify-center">

    <!-- Modal Box -->
    <div class="bg-white rounded-3xl shadow-2xl text-center p-8 relative"
         style="width:1600px;height:600px;">

        <h3 class="text-2xl font-bold text-[#7c3aed] mb-2" style="font-size: 50px; padding:20px;">
            🔐 Email Verification
        </h3>

        <!-- Modal Message -->
        <div id="modalMessage"
             class="text-sm font-medium mb-3 hidden"></div>

        <!-- Countdown -->
        <div id="countdown" class="text-red-500 font-semibold mb-4">
            05:00
        </div>

        <!-- OTP Inputs -->
        <div class="flex justify-center space-x-3 mb-6">
            @for($i=0;$i<6;$i++)
                <input maxlength="1"
                       class="otp-input w-12 h-20 text-center text-xl border-2 border-[#ddd6fe] rounded-lg focus:border-[#7c3aed] focus:outline-none"
                       oninput="moveNext(this)"
                       onkeydown="moveBack(event,this)">
            @endfor
        </div>

        <!-- Loader -->
        <div id="loader" class="hidden mb-4">
            <div class="loader mx-auto"></div>
        </div>

        <button onclick="verifyOtp()"
                class="bg-[#7c3aed] hover:bg-[#6d28d9] text-white w-full py-2 rounded-xl transition" style="height: 80px;">
            Verify OTP
        </button>

        <button onclick="sendOtp(true)"
                id="resendBtn"
                class="mt-3 text-[#7c3aed] font-semibold hidden">
            Resend OTP
        </button>

    </div>
</div>


<script>

let timer;
let timeLeft = 300;

function showModalMessage(message,type="success"){
    let msg=document.getElementById('modalMessage');
    msg.innerText=message;
    msg.classList.remove('hidden','text-red-500','text-green-600');
    msg.classList.add(type==="error"?"text-red-500":"text-green-600");
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

    clearInterval(timer);
    timeLeft=300;
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

async function sendOtp(isResend){

    let email=document.getElementById('email').value;

    if(!email){
        showModalMessage("Email required","error");
        return;
    }

    let response=await fetch("{{ route('admin.send.otp') }}",{
        method:"POST",
        headers:{
            'X-CSRF-TOKEN':'{{ csrf_token() }}',
            'Accept':'application/json',
            'Content-Type':'application/json'
        },
        body:JSON.stringify({email:email})
    });

    let data=await response.json();

    if(!response.ok){
        showModalMessage(data.message || "Error occurred","error");
        return;
    }

    if(data.success){

        if(!isResend){
            document.getElementById('otpModal').classList.remove('hidden');
            setTimeout(()=>{
                document.querySelector('.otp-input').focus();
            },200);
        }

        startTimer();
        showModalMessage("OTP sent successfully","success");

    }else{
        showModalMessage(data.message || "Failed","error");
    }
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

    }else{
        showModalMessage(data.message || "Invalid OTP","error");
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
</style>

@endsection
