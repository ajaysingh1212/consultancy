@extends('admin.layouts.app')

@section('content')

<div class="max-w-6xl mx-auto mt-8">

    <h2 class="text-2xl font-bold text-[#8b5cf6] mb-6">
        ✏ Edit Employer
    </h2>

<form method="POST"
      action="{{ route('admin.employers.update',$employer->id) }}"
      enctype="multipart/form-data">

@csrf
@method('PUT')

<div class="bg-[#f8f7ff] border border-[#e9e7ff]
            rounded-3xl shadow-xl p-8 space-y-10">

{{-- ================= BASIC INFO ================= --}}
<div>
<h3 class="section-title">Basic Information</h3>

<div class="grid grid-cols-4 gap-6">

<div>
<label>Company Name</label>
<input type="text" name="company_name"
value="{{ old('company_name',$employer->company_name) }}"
class="input-style">
</div>

<div>
<label>Company Email</label>
<input type="email" name="company_email"
value="{{ old('company_email',$employer->company_email) }}"
class="input-style">
</div>

<div>
<label>Company Phone</label>
<input type="text" name="company_phone"
value="{{ old('company_phone',$employer->company_phone) }}"
class="input-style">
</div>

<div>
<label>Alternate Phone</label>
<input type="text" name="alternate_phone"
value="{{ old('alternate_phone',$employer->alternate_phone) }}"
class="input-style">
</div>

</div>
</div>

{{-- ================= BRANDING ================= --}}
<div>
<h3 class="section-title">Branding & Social Links</h3>

<div class="grid grid-cols-3 gap-6">

<div>
<label>Logo</label>
<input type="file" name="logo" class="input-style">

@if($employer->logo)
<img src="{{ asset($employer->logo) }}"
class="h-20 mt-2 rounded-lg shadow">
@endif
</div>

<div>
<label>Cover Image</label>
<input type="file" name="cover_image" class="input-style">

@if($employer->cover_image)
<img src="{{ asset($employer->cover_image) }}"
class="h-20 mt-2 rounded-lg shadow">
@endif
</div>

<input type="text" name="website"
value="{{ old('website',$employer->website) }}"
class="input-style" placeholder="Website">

<input type="text" name="linkedin"
value="{{ old('linkedin',$employer->linkedin) }}"
class="input-style" placeholder="LinkedIn">

<input type="text" name="facebook"
value="{{ old('facebook',$employer->facebook) }}"
class="input-style" placeholder="Facebook">

<input type="text" name="twitter"
value="{{ old('twitter',$employer->twitter) }}"
class="input-style" placeholder="Twitter">

</div>
</div>

{{-- ================= COMPANY DETAILS ================= --}}
<div>
<h3 class="section-title">Company Details</h3>

<div class="grid grid-cols-3 gap-6">

<input type="text" name="industry"
value="{{ old('industry',$employer->industry) }}"
class="input-style" placeholder="Industry">

<input type="text" name="company_size"
value="{{ old('company_size',$employer->company_size) }}"
class="input-style" placeholder="Company Size">

<input type="number" name="founded_year"
value="{{ old('founded_year',$employer->founded_year) }}"
class="input-style" placeholder="Founded Year">

<input type="text" name="registration_number"
value="{{ old('registration_number',$employer->registration_number) }}"
class="input-style" placeholder="Registration Number">

<input type="text" name="tax_number"
value="{{ old('tax_number',$employer->tax_number) }}"
class="input-style" placeholder="Tax Number">

<input type="text" name="gst_number"
value="{{ old('gst_number',$employer->gst_number) }}"
class="input-style" placeholder="GST Number">

</div>
</div>

{{-- ================= HR CONTACT ================= --}}
<div>
<h3 class="section-title">HR Contact</h3>

<div class="grid grid-cols-4 gap-6">

<input type="text" name="contact_person_name"
value="{{ old('contact_person_name',$employer->contact_person_name) }}"
class="input-style" placeholder="HR Name">

<input type="email" name="contact_person_email"
value="{{ old('contact_person_email',$employer->contact_person_email) }}"
class="input-style" placeholder="HR Email">

<input type="text" name="contact_person_phone"
value="{{ old('contact_person_phone',$employer->contact_person_phone) }}"
class="input-style" placeholder="HR Phone">

<input type="text" name="contact_person_designation"
value="{{ old('contact_person_designation',$employer->contact_person_designation) }}"
class="input-style" placeholder="Designation">

</div>
</div>

{{-- ================= ADDRESS ================= --}}
<div>
<h3 class="section-title">Address</h3>

<div class="grid grid-cols-3 gap-6">

<textarea name="address"
class="input-style"
placeholder="Address">{{ old('address',$employer->address) }}</textarea>

<input type="text" name="country"
value="{{ old('country',$employer->country) }}"
class="input-style" placeholder="Country">

<input type="text" name="state"
value="{{ old('state',$employer->state) }}"
class="input-style" placeholder="State">

<input type="text" name="city"
value="{{ old('city',$employer->city) }}"
class="input-style" placeholder="City">

<input type="text" name="postal_code"
value="{{ old('postal_code',$employer->postal_code) }}"
class="input-style" placeholder="Postal Code">

</div>
</div>

{{-- ================= FINANCIAL ================= --}}
<div>
<h3 class="section-title">Financial</h3>

<input type="number" step="0.01"
name="wallet_balance"
value="{{ old('wallet_balance',$employer->wallet_balance) }}"
class="input-style" placeholder="Wallet Balance">
</div>

{{-- ================= STATUS ================= --}}
<div>
<h3 class="section-title">Status</h3>

<div class="flex gap-10">

<label class="flex items-center gap-3">
<input type="checkbox" name="is_verified" value="1"
{{ $employer->is_verified ? 'checked' : '' }}>
<span>Verified</span>
</label>

<label class="flex items-center gap-3">
<input type="checkbox" name="is_active" value="1"
{{ $employer->is_active ? 'checked' : '' }}>
<span>Active</span>
</label>

</div>
</div>

<button type="submit"
class="bg-[#8b5cf6] hover:bg-[#7c3aed]
text-white px-8 py-3 rounded-xl shadow-md">
Update Employer
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
.section-title{
    font-size:18px;
    font-weight:600;
    color:#8b5cf6;
    margin-bottom:16px;
}
</style>

@endsection
