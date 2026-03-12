@extends('admin.layouts.app')

@section('content')

<div class="max-w-6xl mx-auto mt-10">

<div class="flex justify-between items-center mb-8">
<h2 class="text-3xl font-bold text-[#7c3aed] flex items-center gap-3">
🧑‍💼 Add Candidate
</h2>

<a href="{{ route('admin.candidates.index') }}"
class="bg-white border border-gray-200 text-[#7c3aed] px-6 py-3 rounded-xl shadow-sm hover:bg-gray-50 transition">
📋 View All
</a>
</div>

<form method="POST"
action="{{ route('admin.candidates.store') }}"
id="candidateForm"
class="bg-white border border-gray-200 rounded-2xl shadow-lg p-10 space-y-8">

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
class="bg-[#7c3aed] hover:bg-[#6d28d9] text-white px-6 py-3 rounded-lg shadow-md transition">
Verify
</button>

</div>

<p id="emailVerifiedMsg"
class="text-green-600 font-medium hidden">
✔ Email Successfully Verified
</p>

</div>

<hr>

<div id="remainingFields"
class="grid grid-cols-1 md:grid-cols-2 gap-6 opacity-50 pointer-events-none transition">

<!-- FULL NAME -->
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
class="w-48 border border-gray-300 rounded-lg"></select>

<input name="mobile"
placeholder="Enter mobile number"
class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:ring-2 focus:ring-[#7c3aed] outline-none">

</div>

<input type="hidden" name="country_code" id="countryCode">

</div>

<!-- PASSPORT -->
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

<!-- NATIONALITY -->
<div>

<label class="block text-sm font-medium text-gray-600 mb-1">
Nationality
</label>

<select id="nationalitySelect"
name="nationality"
class="w-full border border-gray-300 rounded-lg"></select>

</div>

<!-- PASSPORT EXPIRY -->
<div>
<label class="block text-sm font-medium text-gray-600 mb-1">
Passport Expiry
</label>

<input type="date"
name="passport_expiry"
class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:ring-2 focus:ring-[#7c3aed] outline-none">
</div>

<!-- GENDER -->
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

<!-- MARITAL -->
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

<div class="bg-white rounded-3xl shadow-2xl text-center p-8"
style="width:500px">

<h3 class="text-2xl font-bold text-[#7c3aed] mb-4">
🔐 Email Verification
</h3>

<div class="flex justify-center space-x-3 mb-6">

@for($i=0;$i<6;$i++)
<input maxlength="1"
class="otp-input w-12 h-14 text-center text-xl border-2 border-[#ddd6fe] rounded-lg"
oninput="moveNext(this)"
onkeydown="moveBack(event,this)">
@endfor

</div>

<!-- TIMER -->
<p id="otpTimer" class="text-gray-600 mb-3 font-medium"></p>

<!-- RESEND -->
<p id="resendOtp" class="hidden text-[#7c3aed] cursor-pointer font-semibold mb-3" onclick="resendOtp()">
Resend OTP
</p>

<button onclick="verifyOtp()"
class="bg-[#7c3aed] hover:bg-[#6d28d9] text-white w-full py-3 rounded-xl">
Verify OTP
</button>

</div>
</div>
<!-- TOM SELECT -->
<link href="https://cdn.jsdelivr.net/npm/tom-select@2.2.2/dist/css/tom-select.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/tom-select@2.2.2/dist/js/tom-select.complete.min.js"></script>

<script>

/* ---------------------------
   OTP TIMER VARIABLES
--------------------------- */

let otpTimerInterval;
let otpTime = 300;

function startOtpTimer(){

clearInterval(otpTimerInterval);

otpTime = 300;

let timerEl = document.getElementById("otpTimer");
let resendEl = document.getElementById("resendOtp");

if(timerEl) timerEl.innerText = "OTP expires in 5:00";
if(resendEl) resendEl.classList.add("hidden");

otpTimerInterval = setInterval(function(){

let minutes = Math.floor(otpTime / 60);
let seconds = otpTime % 60;

if(seconds < 10) seconds = "0" + seconds;

if(timerEl){
timerEl.innerText = "OTP expires in " + minutes + ":" + seconds;
}

otpTime--;

if(otpTime < 0){

clearInterval(otpTimerInterval);

if(timerEl){
timerEl.innerText = "OTP expired";
}

if(resendEl){
resendEl.classList.remove("hidden");
}

}

},1000);

}

function resendOtp(){

sendOtp();

startOtpTimer();

}


/* ---------------------------
   COUNTRY DATA (FALLBACK)
--------------------------- */

const fallbackCountries = [
{name:"India",code:"+91"},
{name:"United States",code:"+1"},
{name:"United Kingdom",code:"+44"},
{name:"Canada",code:"+1"},
{name:"Australia",code:"+61"},
{name:"Germany",code:"+49"},
{name:"France",code:"+33"},
{name:"Italy",code:"+39"},
{name:"Spain",code:"+34"},
{name:"Netherlands",code:"+31"},
{name:"Belgium",code:"+32"},
{name:"Switzerland",code:"+41"},
{name:"Austria",code:"+43"},
{name:"Denmark",code:"+45"},
{name:"Norway",code:"+47"},
{name:"Sweden",code:"+46"},
{name:"Finland",code:"+358"},
{name:"Russia",code:"+7"},
{name:"Ukraine",code:"+380"},
{name:"Poland",code:"+48"},
{name:"Portugal",code:"+351"},
{name:"Greece",code:"+30"},
{name:"Turkey",code:"+90"},
{name:"UAE",code:"+971"},
{name:"Saudi Arabia",code:"+966"},
{name:"Qatar",code:"+974"},
{name:"Kuwait",code:"+965"},
{name:"Oman",code:"+968"},
{name:"Bahrain",code:"+973"},
{name:"Japan",code:"+81"},
{name:"China",code:"+86"},
{name:"South Korea",code:"+82"},
{name:"Thailand",code:"+66"},
{name:"Vietnam",code:"+84"},
{name:"Malaysia",code:"+60"},
{name:"Singapore",code:"+65"},
{name:"Indonesia",code:"+62"},
{name:"Philippines",code:"+63"},
{name:"Pakistan",code:"+92"},
{name:"Bangladesh",code:"+880"},
{name:"Nepal",code:"+977"},
{name:"Sri Lanka",code:"+94"},
{name:"South Africa",code:"+27"},
{name:"Nigeria",code:"+234"},
{name:"Kenya",code:"+254"},
{name:"Egypt",code:"+20"},
{name:"Morocco",code:"+212"},
{name:"Brazil",code:"+55"},
{name:"Argentina",code:"+54"},
{name:"Mexico",code:"+52"}
];


/* ---------------------------
   LOAD COUNTRIES
--------------------------- */

async function loadCountries(){

let countrySelect = document.getElementById("countrySelect");
let nationalitySelect = document.getElementById("nationalitySelect");

countrySelect.innerHTML="";
nationalitySelect.innerHTML="";

let countriesData=[];

try{

let res = await fetch("https://restcountries.com/v3.1/all");

if(!res.ok) throw new Error("API failed");

let apiCountries = await res.json();

if(Array.isArray(apiCountries)){

countriesData = apiCountries.map(c=>{

let dial="";

if(c.idd && c.idd.root){

dial = c.idd.root + (c.idd.suffixes ? c.idd.suffixes[0] : "");

}

return {
name:c.name.common,
code:dial
};

});

}else{

throw new Error("Invalid API data");

}

}catch(e){

console.warn("Using fallback countries list");

countriesData = fallbackCountries;

}


/* SORT COUNTRIES */

countriesData.sort((a,b)=>a.name.localeCompare(b.name));


/* APPEND OPTIONS */

countriesData.forEach(c=>{

let opt=document.createElement("option");
opt.value=c.code;
opt.text=c.name+(c.code?" ("+c.code+")":"");
countrySelect.appendChild(opt);

let opt2=document.createElement("option");
opt2.value=c.name;
opt2.text=c.name;
nationalitySelect.appendChild(opt2);

});


/* INIT TOMSELECT */

if(!countrySelect.tomselect){

new TomSelect("#countrySelect",{
searchField:"text"
});

}

if(!nationalitySelect.tomselect){

new TomSelect("#nationalitySelect",{
searchField:"text"
});

}


/* AUTO COUNTRY CODE */

countrySelect.addEventListener("change",function(){

document.getElementById("countryCode").value=this.value;

});

}


/* LOAD AFTER PAGE READY */

document.addEventListener("DOMContentLoaded",loadCountries);



/* ---------------------------
   OTP INPUT FUNCTIONS
--------------------------- */

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


/* ---------------------------
   SEND OTP
--------------------------- */

async function sendOtp(){

let email=document.getElementById('email').value;

if(!email){

alert("Please enter email");

return;

}

try{

let response=await fetch("{{ route('admin.send.otp') }}",{

method:"POST",

headers:{
'X-CSRF-TOKEN':'{{ csrf_token() }}',
'Content-Type':'application/json',
'Accept':'application/json'
},

body:JSON.stringify({email:email})

});

let data=await response.json();

if(data.success){

document.getElementById('otpModal').classList.remove('hidden');

startOtpTimer();

setTimeout(()=>{
document.querySelector('.otp-input').focus();
},200);

}else{

alert(data.message || "OTP sending failed");

}

}catch(e){

console.error("OTP error",e);

alert("Server error while sending OTP");

}

}


/* ---------------------------
   VERIFY OTP
--------------------------- */

async function verifyOtp(){

let otp=getOtp();

if(otp.length!==6){

alert("Enter complete OTP");

return;

}

try{

let res=await fetch("{{ route('admin.verify.otp') }}",{

method:"POST",

headers:{
'X-CSRF-TOKEN':'{{ csrf_token() }}',
'Content-Type':'application/json',
'Accept':'application/json'
},

body:JSON.stringify({otp:otp})

});

let data=await res.json();

if(data.success){

clearInterval(otpTimerInterval);

document.getElementById('otpModal').classList.add('hidden');

document.getElementById('remainingFields')
.classList.remove('pointer-events-none','opacity-50');

let submitBtn=document.getElementById('submitBtn');

submitBtn.disabled=false;

submitBtn.classList.remove('bg-gray-400');

submitBtn.classList.add('bg-[#7c3aed]');

document.getElementById('emailVerifiedMsg').classList.remove('hidden');

document.getElementById('verifyBtn').disabled=true;

document.getElementById('email').readOnly=true;

}else{

alert(data.message || "Invalid OTP");

}

}catch(e){

console.error("Verify OTP error",e);

alert("Server error while verifying OTP");

}

}

</script>

@endsection
