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
                              focus:outline-none
                              bg-white shadow-sm">

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
                <label class="block text-sm font-semibold text-gray-700 mb-2">👤 Full Name</label>
                <input name="full_name" class="w-full px-4 py-3 rounded-xl border border-[#ddd6fe] bg-white">
            </div>

            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-2">📱 Mobile</label>
                <input name="mobile" class="w-full px-4 py-3 rounded-xl border border-[#ddd6fe] bg-white">
            </div>

            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-2">🛂 Passport Number</label>
                <input name="passport_number" class="w-full px-4 py-3 rounded-xl border border-[#ddd6fe] bg-white">
            </div>

            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-2">🎂 Date of Birth</label>
                <input type="date" name="dob" class="w-full px-4 py-3 rounded-xl border border-[#ddd6fe] bg-white">
            </div>

            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-2">🌍 Nationality</label>
                <input name="nationality" class="w-full px-4 py-3 rounded-xl border border-[#ddd6fe] bg-white">
            </div>

            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-2">📅 Passport Expiry</label>
                <input type="date" name="passport_expiry" class="w-full px-4 py-3 rounded-xl border border-[#ddd6fe] bg-white">
            </div>

            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-2">🚻 Gender</label>
                <select name="gender" class="w-full px-4 py-3 rounded-xl border border-[#ddd6fe] bg-white">
                    <option value="">Select Gender</option>
                    <option>Male</option>
                    <option>Female</option>
                </select>
            </div>

            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-2">💍 Marital Status</label>
                <select name="marital_status" class="w-full px-4 py-3 rounded-xl border border-[#ddd6fe] bg-white">
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
     class="fixed inset-0 bg-black bg-opacity-50 hidden
            flex items-center justify-center z-50">

    <div class="bg-white p-8 rounded-3xl w-96 shadow-2xl">

        <h3 class="text-2xl font-bold text-[#7c3aed] mb-4 text-center">
            🔐 Email Verification
        </h3>

        <input id="otp"
               maxlength="6"
               class="w-full px-4 py-3 border border-[#ddd6fe]
                      rounded-xl text-center text-xl tracking-widest
                      focus:ring-2 focus:ring-[#7c3aed]
                      focus:outline-none"
               placeholder="------">

        <button onclick="verifyOtp()"
                class="mt-6 w-full bg-[#7c3aed]
                       hover:bg-[#6d28d9]
                       text-white py-3 rounded-xl transition">
            Verify OTP
        </button>

        <button onclick="closeModal()"
                class="mt-3 w-full text-gray-500 text-sm">
            Cancel
        </button>

    </div>
</div>


<script>

async function sendOtp() {

    let email = document.getElementById('email').value;

    if(email === ''){
        alert("Please enter email first.");
        return;
    }

    try {

        let response = await fetch("{{ route('admin.send.otp') }}", {
            method: "POST",
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                'Accept': 'application/json',
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({ email: email })
        });

        if (!response.ok) {
            throw new Error("Server error");
        }

        let data = await response.json();

        if(data.success){
            document.getElementById('otpModal').classList.remove('hidden');
        } else {
            alert("Failed to send OTP.");
        }

    } catch (error) {
        alert("Something went wrong. Check console.");
        console.error(error);
    }
}

async function verifyOtp() {

    let otp = document.getElementById('otp').value;

    try {

        let response = await fetch("{{ route('admin.verify.otp') }}", {
            method: "POST",
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Accept': 'application/json',
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({ otp: otp })
        });

        if (!response.ok) {
            throw new Error("Server error");
        }

        let data = await response.json();

        if(data.success){

            document.getElementById('otpModal').classList.add('hidden');
            document.getElementById('remainingFields')
                .classList.remove('pointer-events-none','opacity-50');

            document.getElementById('submitBtn').disabled = false;
            document.getElementById('submitBtn')
                .classList.remove('bg-gray-400');
            document.getElementById('submitBtn')
                .classList.add('bg-[#7c3aed]');

            document.getElementById('emailVerifiedMsg')
                .classList.remove('hidden');

            document.getElementById('verifyBtn').disabled = true;

        } else {
            alert("Invalid OTP.");
        }

    } catch (error) {
        alert("Something went wrong.");
        console.error(error);
    }
}

function closeModal(){
    document.getElementById('otpModal').classList.add('hidden');
}

</script>

@endsection
