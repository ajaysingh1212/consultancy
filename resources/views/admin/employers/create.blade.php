@extends('admin.layouts.app')

@section('content')

<div class="max-w-7xl mx-auto mt-8">

    <h2 class="text-2xl font-bold text-[#8b5cf6] mb-6">
        🏢 Create Employer
    </h2>

<form method="POST"
      action="{{ route('admin.employers.store') }}"
      enctype="multipart/form-data">

@csrf

<div class="bg-[#f8f7ff] border border-[#e9e7ff]
            rounded-3xl shadow-xl p-8 space-y-10">

{{-- ================= BASIC INFO ================= --}}
<div>
<h3 class="text-lg font-semibold text-[#8b5cf6] mb-4">
Basic Information
</h3>

<div class="grid grid-cols-2 gap-6">

<input type="text" name="company_name"
class="input-style" placeholder="Company Name">

<input type="email" name="company_email"
class="input-style" placeholder="Company Email">

<input type="text" name="company_phone"
class="input-style" placeholder="Company Phone">

<input type="text" name="alternate_phone"
class="input-style" placeholder="Alternate Phone">

</div>
</div>

{{-- ================= BRANDING ================= --}}
<div>
<h3 class="text-lg font-semibold text-[#8b5cf6] mb-4">
Branding & Links
</h3>

<div class="grid grid-cols-2 gap-6">

<input type="file" name="logo" class="input-style">
<input type="file" name="cover_image" class="input-style">

<input type="text" name="website" class="input-style" placeholder="Website">
<input type="text" name="linkedin" class="input-style" placeholder="LinkedIn">

<input type="text" name="facebook" class="input-style" placeholder="Facebook">
<input type="text" name="twitter" class="input-style" placeholder="Twitter">

</div>
</div>

{{-- ================= COMPANY DETAILS ================= --}}
<div>
<h3 class="text-lg font-semibold text-[#8b5cf6] mb-4">
Company Details
</h3>

<div class="grid grid-cols-3 gap-6">

<input type="text" name="industry" class="input-style" placeholder="Industry">
<input type="text" name="company_size" class="input-style" placeholder="Company Size">
<input type="number" name="founded_year" class="input-style" placeholder="Founded Year">

<input type="text" name="registration_number" class="input-style" placeholder="Registration No">
<input type="text" name="tax_number" class="input-style" placeholder="Tax Number">
<input type="text" name="gst_number" class="input-style" placeholder="GST Number">

</div>
</div>

{{-- ================= HR CONTACT ================= --}}
<div>
<h3 class="text-lg font-semibold text-[#8b5cf6] mb-4">
HR Contact
</h3>

<div class="grid grid-cols-2 gap-6">

<input type="text" name="contact_person_name" class="input-style" placeholder="HR Name">
<input type="email" name="contact_person_email" class="input-style" placeholder="HR Email">

<input type="text" name="contact_person_phone" class="input-style" placeholder="HR Phone">
<input type="text" name="contact_person_designation" class="input-style" placeholder="Designation">

</div>
</div>

{{-- ================= ADDRESS ================= --}}
<div>
<h3 class="text-lg font-semibold text-[#8b5cf6] mb-4">
Address
</h3>

<div class="grid grid-cols-2 gap-6">

<textarea name="address" class="input-style" placeholder="Address"></textarea>

<input type="text" name="country" class="input-style" placeholder="Country">
<input type="text" name="state" class="input-style" placeholder="State">
<input type="text" name="city" class="input-style" placeholder="City">
<input type="text" name="postal_code" class="input-style" placeholder="Postal Code">

</div>
</div>

{{-- ================= STATUS ================= --}}
<div>
<h3 class="text-lg font-semibold text-[#8b5cf6] mb-4">
Status
</h3>

<div class="flex gap-10">

<label class="flex items-center gap-3">
<input type="checkbox" name="is_verified" value="1">
<span>Verified</span>
</label>

<label class="flex items-center gap-3">
<input type="checkbox" name="is_active" value="1" checked>
<span>Active</span>
</label>

</div>
</div>

<button type="submit"
class="bg-[#8b5cf6] hover:bg-[#7c3aed]
text-white px-8 py-3 rounded-xl shadow-md">
Save Employer
</button>

</div>
</form>
</div>

<style>
.input-style{
    border:1px solid #e9e7ff;
    background:white;
    padding:12px 15px;
    border-radius:14px;
    width:100%;
    transition:0.3s;
}
.input-style:focus{
    outline:none;
    border-color:#8b5cf6;
    box-shadow:0 0 0 2px #ede9fe;
}
</style>

@endsection
