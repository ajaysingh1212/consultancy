@extends('admin.layouts.app')

@section('content')

<div class="max-w-4xl mx-auto mt-8">

<h2 class="text-2xl font-bold text-[#8b5cf6] mb-6">
✏ Edit Skill
</h2>

<form method="POST"
action="{{ route('admin.skills.update',$skill) }}">
@csrf
@method('PUT')

<div class="card space-y-8">

<div>
<label>Skill Name</label>
<input type="text"
name="name"
value="{{ old('name',$skill->name) }}"
class="input-style"
required>
</div>

<div>
<label>Category</label>
<input type="text"
name="category"
value="{{ old('category',$skill->category) }}"
class="input-style">
</div>

<div>
<label>Description</label>
<textarea name="description"
class="input-style">{{ old('description',$skill->description) }}</textarea>
</div>

<div>
<input type="hidden" name="is_active" value="0">

<label class="flex items-center gap-2">
<input type="checkbox"
name="is_active"
value="1"
{{ $skill->is_active ? 'checked' : '' }}>
Active
</label>
</div>

<button class="submit-btn">
Update Skill
</button>

</div>
</form>

</div>

@endsection
