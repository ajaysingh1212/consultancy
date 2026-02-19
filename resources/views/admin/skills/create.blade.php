@extends('admin.layouts.app')

@section('content')

<div class="max-w-6xl mx-auto mt-8">

    <h2 class="text-2xl font-bold text-[#8b5cf6] mb-6">
        ➕ Create Skill
    </h2>

<form method="POST"
      action="{{ route('admin.skills.store') }}">

@csrf

<div class="bg-[#f8f7ff] border border-[#e9e7ff]
            rounded-3xl shadow-xl p-8 space-y-10">

{{-- ================= BASIC INFO ================= --}}
<div>
<h3 class="text-lg font-semibold text-[#8b5cf6] mb-4">
Skill Information
</h3>

<div class="grid grid-cols-3 gap-6">

<div>
<label class="text-sm font-medium">Skill Name</label>
<input type="text" name="name"
class="input-style"
placeholder="Skill Name"
required>
</div>

<div>
<label class="text-sm font-medium">Category</label>
<input type="text" name="category"
class="input-style"
placeholder="Category (e.g. Programming)">
</div>

<div>
<label class="text-sm font-medium">Status</label>

<input type="hidden" name="is_active" value="0">

<label class="flex items-center gap-3 mt-3">
<input type="checkbox"
name="is_active"
value="1"
checked>
<span>Active</span>
</label>

</div>

</div>
</div>

{{-- ================= DESCRIPTION ================= --}}
<div>
<h3 class="text-lg font-semibold text-[#8b5cf6] mb-4">
Description
</h3>

<textarea name="description"
class="input-style"
rows="4"
placeholder="Skill Description"></textarea>

</div>

{{-- ================= MAIN BUTTONS ================= --}}
<div class="flex gap-4 pt-4">

    <a href="{{ route('admin.skills.index') }}"
       class="px-8 py-3 rounded-xl
              border border-[#e9e7ff]
              bg-white
              hover:bg-[#ede9fe]
              transition shadow-sm">
          Cancel
    </a>

    <button type="submit"
        class="bg-[#8b5cf6] hover:bg-[#7c3aed]
        text-white px-8 py-3 rounded-xl shadow-md transition">
        💾 Save Skill
    </button>

</div>

</div>

{{-- ================= BOTTOM CANCEL SECTION ================= --}}
<div class="text-center mt-6">
    <a href="{{ route('admin.skills.index') }}"
       class="text-[#8b5cf6] font-medium hover:underline">
        ⬅ Back to Skills List
    </a>
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
