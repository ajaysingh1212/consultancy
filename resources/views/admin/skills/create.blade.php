@extends('admin.layouts.app')

@section('content')

<div class="max-w-4xl mx-auto mt-8">

<h2 class="text-2xl font-bold text-[#8b5cf6] mb-6">
➕ Create Skill
</h2>

<form method="POST"
action="{{ route('admin.skills.store') }}">
@csrf

<div class="card space-y-8">

<div>
<label>Skill Name</label>
<input type="text"
name="name"
class="input-style"
placeholder="Skill Name"
required>
</div>

<div>
<label>Category</label>
<input type="text"
name="category"
class="input-style"
placeholder="Category (e.g. Programming)">
</div>

<div>
<label>Description</label>
<textarea name="description"
class="input-style"
placeholder="Skill Description"></textarea>
</div>

<div>
<input type="hidden" name="is_active" value="0">

<label class="flex items-center gap-2">
<input type="checkbox"
name="is_active"
value="1"
checked>
Active
</label>
</div>

<button class="submit-btn">
Save Skill
</button>

</div>
</form>

</div>

@endsection
