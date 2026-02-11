@extends('admin.layouts.app')

@section('content')

<div class="max-w-6xl mx-auto mt-10">

    <!-- Header -->
    <div class="flex justify-between items-center mb-8">
        <h2 class="text-2xl font-bold text-[#8b5cf6] flex items-center gap-2">
            🧑‍💼 Add Candidate
        </h2>

        <a href="{{ route('admin.candidates.index') }}"
           class="bg-white border border-[#e9e7ff]
                  text-[#8b5cf6] px-5 py-2.5
                  rounded-xl shadow-sm
                  hover:bg-[#ede9fe]
                  transition flex items-center gap-2">
            📋 View All
        </a>
    </div>

    <!-- Card -->
    <form method="POST"
          action="{{ route('admin.candidates.store') }}"
          class="bg-[#f8f7ff] border border-[#e9e7ff]
                 rounded-3xl shadow-xl p-8">

        @csrf

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

            <!-- Full Name -->
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-2">
                    👤 Full Name
                </label>
                <input name="full_name"
                       placeholder="Enter full name"
                       class="w-full px-4 py-3 rounded-xl
                              border border-[#e9e7ff]
                              focus:ring-2 focus:ring-[#8b5cf6]
                              focus:outline-none
                              bg-white">
            </div>

            <!-- Mobile -->
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-2">
                    📱 Mobile
                </label>
                <input name="mobile"
                       placeholder="Enter mobile number"
                       class="w-full px-4 py-3 rounded-xl
                              border border-[#e9e7ff]
                              focus:ring-2 focus:ring-[#8b5cf6]
                              focus:outline-none
                              bg-white">
            </div>

            <!-- Passport Number -->
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-2">
                    🛂 Passport Number
                </label>
                <input name="passport_number"
                       placeholder="Enter passport number"
                       class="w-full px-4 py-3 rounded-xl
                              border border-[#e9e7ff]
                              focus:ring-2 focus:ring-[#8b5cf6]
                              focus:outline-none
                              bg-white">
            </div>

            <!-- DOB -->
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-2">
                    🎂 Date of Birth
                </label>
                <input type="date"
                       name="dob"
                       class="w-full px-4 py-3 rounded-xl
                              border border-[#e9e7ff]
                              focus:ring-2 focus:ring-[#8b5cf6]
                              focus:outline-none
                              bg-white">
            </div>

            <!-- Nationality -->
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-2">
                    🌍 Nationality
                </label>
                <input name="nationality"
                       placeholder="Enter nationality"
                       class="w-full px-4 py-3 rounded-xl
                              border border-[#e9e7ff]
                              focus:ring-2 focus:ring-[#8b5cf6]
                              focus:outline-none
                              bg-white">
            </div>

            <!-- Passport Expiry -->
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-2">
                    📅 Passport Expiry
                </label>
                <input type="date"
                       name="passport_expiry"
                       class="w-full px-4 py-3 rounded-xl
                              border border-[#e9e7ff]
                              focus:ring-2 focus:ring-[#8b5cf6]
                              focus:outline-none
                              bg-white">
            </div>

            <!-- Gender -->
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-2">
                    🚻 Gender
                </label>
                <select name="gender"
                        class="w-full px-4 py-3 rounded-xl
                               border border-[#e9e7ff]
                               focus:ring-2 focus:ring-[#8b5cf6]
                               focus:outline-none
                               bg-white">
                    <option value="">Select Gender</option>
                    <option>Male</option>
                    <option>Female</option>
                </select>
            </div>

            <!-- Marital Status -->
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-2">
                    💍 Marital Status
                </label>
                <select name="marital_status"
                        class="w-full px-4 py-3 rounded-xl
                               border border-[#e9e7ff]
                               focus:ring-2 focus:ring-[#8b5cf6]
                               focus:outline-none
                               bg-white">
                    <option value="">Select Status</option>
                    <option>Single</option>
                    <option>Married</option>
                </select>
            </div>

        </div>

        <!-- Buttons -->
        <div class="mt-8 flex gap-4">

            <button type="submit"
                    class="bg-[#9f7aea] hover:bg-[#7c3aed]
                           text-white px-6 py-3
                           rounded-xl shadow-md
                           transition flex items-center gap-2">
                💾 Save Candidate
            </button>

            <a href="{{ route('admin.candidates.index') }}"
               class="px-6 py-3 rounded-xl
                      border border-[#e9e7ff]
                      bg-white
                      hover:bg-[#ede9fe]
                      transition flex items-center gap-2">
                ❌ Cancel
            </a>

        </div>

    </form>

</div>

@endsection
