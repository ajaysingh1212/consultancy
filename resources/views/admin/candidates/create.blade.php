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
            <label class="block text-lg font-semibold text-gray-700 mb-3">
                📧 Email Address
            </label>

            <div class="flex gap-4">
                <input type="email"
                       name="email"
                       id="email"
                       required
                       placeholder="Enter candidate email"
                       class="w-full px-5 py-4 rounded-2xl
                              border border-[#ddd6fe]
                              focus:ring-2 focus:ring-[#7c3aed]
                              focus:outline-none bg-white shadow-sm">

                <button type="button"
                        onclick="sendOtp()"
                        id="verifyBtn"
                        class="bg-[#7c3aed] hover:bg-[#6d28d9]
                               text-white px-6 py-4
                               rounded-2xl shadow-md transition">
                    Verify
                </button>
            </div>

            <p id="emailVerifiedMsg"
               class="text-green-600 font-medium mt-3 hidden">
                ✅ Email Successfully Verified
            </p>
        </div>

        <hr class="mb-8 border-[#e9d5ff]">

        <!-- REST FORM -->
        <div id="remainingFields"
             class="grid grid-cols-1 md:grid-cols-2 gap-6
                    opacity-50 pointer-events-none transition duration-300">

            <div>
                <label class="block text-sm font-semibold mb-2">👤 Full Name</label>
                <input name="full_name" class="w-full px-4 py-3 rounded-xl border border-[#ddd6fe]">
            </div>

            <div>
                <label class="block text-sm font-semibold mb-2">📱 Mobile</label>
                <input name="mobile" class="w-full px-4 py-3 rounded-xl border border-[#ddd6fe]">
            </div>

            <div>
                <label class="block text-sm font-semibold mb-2">🛂 Passport Number</label>
                <input name="passport_number" class="w-full px-4 py-3 rounded-xl border border-[#ddd6fe]">
            </div>

            <div>
                <label class="block text-sm font-semibold mb-2">🎂 Date of Birth</label>
                <input type="date" name="dob" class="w-full px-4 py-3 rounded-xl border border-[#ddd6fe]">
            </div>

            <div>
                <label class="block text-sm font-semibold mb-2">🌍 Nationality</label>
                <input name="nationality" class="w-full px-4 py-3 rounded-xl border border-[#ddd6fe]">
            </div>

            <div>
                <label class="block text-sm font-semibold mb-2">📅 Passport Expiry</label>
                <input type="date" name="passport_expiry" class="w-full px-4 py-3 rounded-xl border border-[#ddd6fe]">
            </div>

            <div>
                <label class="block text-sm font-semibold mb-2">🚻 Gender</label>
                <select name="gender" class="w-full px-4 py-3 rounded-xl border border-[#ddd6fe]">
                    <option value="">Select Gender</option>
                    <option>Male</option>
                    <option>Female</option>
                </select>
            </div>

            <div>
                <label class="block text-sm font-semibold mb-2">💍 Marital Status</label>
                <select name="marital_status" class="w-full px-4 py-3 rounded-xl border border-[#ddd6fe]">
                    <option value="">Select Status</option>
                    <option>Single</option>
                    <option>Married</option>
                </select>
            </div>

        </div>

        <div class="mt-10">
            <button type="submit"
                    id="submitBtn"
                    disabled
                    class="bg-gray-400 text-white px-8 py-4 rounded-2xl shadow-md transition">
                💾 Save Candidate
            </button>
        </div>

    </form>
</div>


<!-- OTP MODAL -->
<div id="otpModal"
     class="fixed inset-0 bg-black bg-opacity-50 hidden flex items-center justify-center z-50">

    <div class="bg-white p-8 rounded-3xl w-96 shadow-2xl text-center animate-scale">

        <h3 class="text-2xl font-bold text-[#7c3aed] mb-4">
            🔐 Email Verification
        </h3>

        <div class="text-red-500 font-semibold mb-3" id="countdown">
            05:00
        </div>

        <!-- 6 Digit OTP -->
        <div class="flex justify-center gap-2 mb-4">
            @for($i=0;$i<6;$i++)
                <input maxlength="1"
                       class="otp-input w-12 h-12 text-center text-xl border rounded-lg focus:ring-2 focus:ring-[#7c3aed]"
                       oninput="moveNext(this)"
                       onkeydown="moveBack(event,this)">
            @endfor
        </div>

        <button onclick="verifyOtp()"
                class="bg-[#7c3aed] text-white w-full py-3 rounded-xl transition">
            Verify OTP
        </button>

        <button onclick="resendOtp()"
                id="resendBtn"
                class="mt-3 text-[#7c3aed] font-semibold hidden">
            Resend OTP
        </button>

    </div>
</div>

<!-- Toast -->
<div id="toast"
     class="fixed bottom-5 right-5 px-6 py-3 rounded-lg text-white hidden">
</div>


<script>

let timer;
let timeLeft = 300;

function showToast(message, type="success") {
    let toast = document.getElementById('toast');
    toast.innerText = message;
    toast.classList.remove('hidden');
    toast.style.background = type === "error" ? "#dc2626" : "#16a34a";
    setTimeout(()=>toast.classList.add('hidden'),3000);
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
        showToast(data.message || "Failed","error");
    }
}

async function resendOtp(){
    clearInterval(timer);
    await sendOtp();
}

async function verifyOtp(){

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

    if(data.success){

        clearInterval(timer);
        document.getElementById('otpModal').classList.add('hidden');

        document.getElementById('remainingFields')
            .classList.remove('pointer-events-none','opacity-50');

        document.getElementById('submitBtn').disabled=false;
        document.getElementById('submitBtn').classList.remove('bg-gray-400');
        document.getElementById('submitBtn').classList.add('bg-[#7c3aed]');

        document.getElementById('emailVerifiedMsg').classList.remove('hidden');
        document.getElementById('verifyBtn').disabled=true;
        document.getElementById('email').readOnly=true;

        showToast("Email Verified Successfully 🎉");

    }else{
        showToast(data.message || "Invalid OTP","error");
    }
}

</script>

<style>
@keyframes scaleIn{
    from{transform:scale(0.8);opacity:0;}
    to{transform:scale(1);opacity:1;}
}
.animate-scale{
    animation:scaleIn 0.2s ease-in-out;
}
</style>

@endsection
