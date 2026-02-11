@extends('admin.layouts.app')

@section('content')

<div class="max-w-4xl mx-auto mt-10">

    <!-- Card -->
    <div class="bg-[#f8f7ff] border border-[#e9e7ff] 
                rounded-3xl shadow-xl p-8">

        <!-- Header -->
        <div class="flex items-center justify-between mb-6">
            <h2 class="text-2xl font-bold text-[#8b5cf6] flex items-center gap-2">
                ✏️ Edit Role
            </h2>

            <a href="{{ route('admin.roles.index') }}"
               class="text-[#8b5cf6] hover:text-[#6d28d9] 
                      transition flex items-center gap-1 font-medium">
                ← Back
            </a>
        </div>

        <form method="POST" action="{{ route('admin.roles.update',$role) }}">
        @csrf
        @method('PUT')

            <!-- Role Name -->
            <div class="mb-6">
                <label class="block font-semibold text-gray-700 mb-2 flex items-center gap-2">
                    🛡 Role Name
                </label>

                <input name="name"
                       value="{{ $role->name }}"
                       class="w-full px-4 py-3 rounded-xl 
                              border border-[#e9e7ff] 
                              bg-white
                              focus:outline-none 
                              focus:ring-2 
                              focus:ring-[#8b5cf6]
                              shadow-sm"
                       required>
            </div>

            <!-- Permissions -->
            <div class="mb-6">

                <div class="flex items-center justify-between mb-3">
                    <label class="font-semibold text-gray-700 flex items-center gap-2">
                        🔐 Permissions
                    </label>

                    <!-- Select All -->
                    <label class="flex items-center gap-2 text-sm text-[#8b5cf6] cursor-pointer">
                        <input type="checkbox" id="selectAll"
                               class="accent-[#8b5cf6]">
                        Select All
                    </label>
                </div>

                <div class="grid grid-cols-2 md:grid-cols-3 gap-3">

                    @foreach($permissions as $permission)
                    <label class="flex items-center gap-2 
                                   bg-white border border-[#e9e7ff]
                                   rounded-xl px-3 py-2 
                                   shadow-sm hover:bg-[#ede9fe] 
                                   transition cursor-pointer">

                        <input type="checkbox"
                               name="permissions[]"
                               value="{{ $permission->name }}"
                               class="permission-checkbox accent-[#8b5cf6]"
                               {{ in_array($permission->name, $rolePermissions) ? 'checked' : '' }}>

                        <span class="text-sm text-gray-700">
                            {{ $permission->name }}
                        </span>
                    </label>
                    @endforeach

                </div>
            </div>

            <!-- Buttons -->
            <div class="flex items-center gap-4 mt-6">

                <button type="submit"
                        class="bg-[#9f7aea] hover:bg-[#7c3aed] 
                               text-white px-6 py-3 
                               rounded-xl shadow-md 
                               transition flex items-center gap-2">
                    💾 Update Role
                </button>

                <a href="{{ route('admin.roles.index') }}"
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

</div>

<!-- Select All Script -->
<script>
    document.getElementById('selectAll').addEventListener('click', function() {
        let checkboxes = document.querySelectorAll('.permission-checkbox');
        checkboxes.forEach(cb => cb.checked = this.checked);
    });
</script>

@endsection
