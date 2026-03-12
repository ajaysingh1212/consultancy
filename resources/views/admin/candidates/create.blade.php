@extends('admin.layouts.app')

@section('content')

<div class="max-w-6xl mx-auto mt-10">

<!-- Header -->
<div class="flex justify-between items-center mb-8">
<h2 class="text-3xl font-bold text-[#7c3aed] flex items-center gap-3">
🧑‍💼 Add Candidate
</h2>

<a href="{{ route('admin.candidates.index') }}"
class="bg-white border border-gray-200
text-[#7c3aed] px-6 py-3
rounded-xl shadow-sm
hover:bg-gray-50 transition">
📋 View All
</a>
</div>

<form method="POST"
action="{{ route('admin.candidates.store') }}"
id="candidateForm"
class="bg-white border border-gray-200
rounded-2xl shadow-lg p-10 space-y-8">

@csrf

<!-- EMAIL -->
<div class="space-y-3">
<label class="block font-semibold text-gray-700">
📧 Email Address
</label>

<div class="flex gap-4">
<input type="email"
name="email"
id="email"
required
class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:ring-2 focus:ring-[#7c3aed] outline-none">

<button type="button"
onclick="sendOtp(false)"
id="verifyBtn"
class="bg-[#7c3aed] hover:bg-[#6d28d9]
text-white px-6 py-3 rounded-lg shadow-md transition">
Verify
</button>
</div>

<p id="emailVerifiedMsg"
class="text-green-600 font-medium hidden">
✔ Email Successfully Verified
</p>
</div>

<hr>

<!-- FORM FIELDS -->
<div id="remainingFields"
class="grid grid-cols-1 md:grid-cols-2 gap-6 opacity-50 pointer-events-none transition">

<!-- Full Name -->
<div>
<label class="block text-sm font-medium text-gray-600 mb-1">
Full Name
</label>
<input name="full_name"
class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:ring-2 focus:ring-[#7c3aed] outline-none">
</div>

<!-- MOBILE WITH COUNTRY -->
<div>

<label class="block text-sm font-medium text-gray-600 mb-1">
Mobile
</label>

<div class="flex gap-2">

<select id="countrySelect"
class="w-40 border border-gray-300 rounded-lg"></select>

<input id="mobile"
name="mobile"
placeholder="Mobile number"
class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:ring-2 focus:ring-[#7c3aed] outline-none">

</div>

<input type="hidden" name="country_code" id="countryCode">

</div>

<!-- Passport -->
<div>
<label class="block text-sm font-medium text-gray-600 mb-1">
Passport Number
</label>
<input name="passport_number"
class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:ring-2 focus:ring-[#7c3aed] outline-none">
</div>

<!-- DOB -->
<div>
<label class="block text-sm font-medium text-gray-600 mb-1">
Date of Birth
</label>
<input type="date"
name="dob"
class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:ring-2 focus:ring-[#7c3aed] outline-none">
</div>

<!-- Nationality -->
<div>
<label class="block text-sm font-medium text-gray-600 mb-1">
Nationality
</label>

<select id="nationalitySelect"
name="nationality"
class="w-full border border-gray-300 rounded-lg"></select>

</div>

<!-- Passport Expiry -->
<div>
<label class="block text-sm font-medium text-gray-600 mb-1">
Passport Expiry
</label>
<input type="date"
name="passport_expiry"
class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:ring-2 focus:ring-[#7c3aed] outline-none">
</div>

<!-- Gender -->
<div>
<label class="block text-sm font-medium text-gray-600 mb-1">
Gender
</label>

<select name="gender"
class="w-full px-4 py-3 rounded-lg border border-gray-300">
<option value="">Select Gender</option>
<option>Male</option>
<option>Female</option>
</select>

</div>

<!-- Marital -->
<div>
<label class="block text-sm font-medium text-gray-600 mb-1">
Marital Status
</label>

<select name="marital_status"
class="w-full px-4 py-3 rounded-lg border border-gray-300">
<option value="">Select Status</option>
<option>Single</option>
<option>Married</option>
</select>

</div>

</div>

<button type="submit"
id="submitBtn"
disabled
class="bg-gray-400 text-white px-8 py-3 rounded-lg transition">
💾 Save Candidate
</button>

</form>

</div>

<!-- OTP MODAL -->
<div id="otpModal"
class="fixed inset-0 bg-black bg-opacity-60 hidden z-50 flex items-center justify-center">

<div class="bg-white rounded-3xl shadow-2xl text-center p-8 relative"
style="width:500px;">

<h3 class="text-2xl font-bold text-[#7c3aed] mb-4">
🔐 Email Verification
</h3>

<div id="modalMessage"
class="text-sm font-medium mb-3 hidden"></div>

<div id="countdown" class="text-red-500 font-semibold mb-4">
05:00
</div>

<div class="flex justify-center space-x-3 mb-6">
@for($i=0;$i<6;$i++)
<input maxlength="1"
class="otp-input w-12 h-14 text-center text-xl border-2 border-[#ddd6fe] rounded-lg"
oninput="moveNext(this)"
onkeydown="moveBack(event,this)">
@endfor
</div>

<button onclick="verifyOtp()"
class="bg-[#7c3aed] hover:bg-[#6d28d9] text-white w-full py-3 rounded-xl">
Verify OTP
</button>

<button onclick="sendOtp(true)"
id="resendBtn"
class="mt-3 text-[#7c3aed] font-semibold hidden">
Resend OTP
</button>

</div>
</div>


<!-- CDN -->
<link href="https://cdn.jsdelivr.net/npm/tom-select@2.2.2/dist/css/tom-select.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/tom-select@2.2.2/dist/js/tom-select.complete.min.js"></script>

<script>

let countries=[
{name:"India",code:"+91"},
{name:"United States",code:"+1"},
{name:"United Kingdom",code:"+44"},
{name:"Canada",code:"+1"},
{name:"Australia",code:"+61"},
{name:"UAE",code:"+971"},
{name:"Saudi Arabia",code:"+966"},
{name:"Qatar",code:"+974"},
{name:"Oman",code:"+968"},
{name:"Kuwait",code:"+965"},
{name:"Germany",code:"+49"},
{name:"France",code:"+33"},
{name:"Italy",code:"+39"},
{name:"Spain",code:"+34"},
{name:"China",code:"+86"},
{name:"Japan",code:"+81"},
{name:"Pakistan",code:"+92"},
{name:"Bangladesh",code:"+880"},
{name:"Nepal",code:"+977"},
{name:"Sri Lanka",code:"+94"}
];

let countrySelect=document.getElementById("countrySelect");
let nationalitySelect=document.getElementById("nationalitySelect");

countries.forEach(c=>{
let opt=document.createElement("option");
opt.value=c.code;
opt.text=c.name+" ("+c.code+")";
countrySelect.appendChild(opt);

let opt2=document.createElement("option");
opt2.value=c.name;
opt2.text=c.name;
nationalitySelect.appendChild(opt2);
});

new TomSelect("#countrySelect",{searchField:"text"});
new TomSelect("#nationalitySelect",{searchField:"text"});

countrySelect.addEventListener("change",function(){
document.getElementById("countryCode").value=this.value;
});

</script>


<script>

let timer;
let timeLeft=300;

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

async function sendOtp(isResend){

let email=document.getElementById('email').value;

let response=await fetch("{{ route('admin.send.otp') }}",{
method:"POST",
headers:{
'X-CSRF-TOKEN':'{{ csrf_token() }}',
'Content-Type':'application/json'
},
body:JSON.stringify({email:email})
});

let data=await response.json();

if(data.success){

document.getElementById('otpModal').classList.remove('hidden');

}else{
alert(data.message);
}

}

async function verifyOtp(){

let otp=getOtp();

let res=await fetch("{{ route('admin.verify.otp') }}",{
method:"POST",
headers:{
'X-CSRF-TOKEN':'{{ csrf_token() }}',
'Content-Type':'application/json'
},
body:JSON.stringify({otp:otp})
});

let data=await res.json();

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
alert("Invalid OTP");
}

}

</script>

@endsection
