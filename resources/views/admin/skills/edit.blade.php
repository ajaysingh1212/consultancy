@extends('admin.layouts.app')

@section('content')

<div class="max-w-6xl mx-auto mt-8">

    <h2 class="text-2xl font-bold text-[#8b5cf6] mb-6">
        ✏ Edit Skill
    </h2>

<form method="POST"
      action="{{ route('admin.skills.update',$skill) }}">

@csrf
@method('PUT')

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
<input type="text"
       name="name"
       value="{{ old('name',$skill->name) }}"
       class="input-style"
       required>
</div>

<div>
<label class="text-sm font-medium">Category</label>
<input type="text"
       name="category"
       value="{{ old('category',$skill->category) }}"
       class="input-style">
</div>

<div>
<label class="text-sm font-medium">Status</label>

<input type="hidden" name="is_active" value="0">

<label class="flex items-center gap-3 mt-3">
<input type="checkbox"
       name="is_active"
       value="1"
       {{ $skill->is_active ? 'checked' : '' }}>
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
          rows="4"
          class="input-style"
          placeholder="Skill Description">{{ old('description',$skill->description) }}</textarea>

</div>

{{-- ================= BUTTONS ================= --}}
<div class="flex  gap-4 pt-4">

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
        💾 Update Skill
    </button>

</div>

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
