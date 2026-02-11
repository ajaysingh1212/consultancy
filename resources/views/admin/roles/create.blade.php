@extends('admin.layouts.app')

@section('content')

<div class="max-w-4xl mx-auto mt-8">

    <div class="bg-[#f8f7ff] border border-[#e9e7ff] rounded-3xl shadow-lg p-8">

        <!-- Heading -->
        <h2 class="text-2xl font-bold text-[#8b5cf6] mb-8">
            ✨ Create Role
        </h2>

        <form method="POST" action="{{ route('admin.roles.store') }}">
        @csrf

            <!-- Role Name -->
            <div class="mb-8">
                <label class="block font-semibold text-gray-700 mb-2">
                    Role Name
                </label>

                <input name="name"
                       class="w-full px-4 py-3 rounded-xl 
                              border border-[#e9e7ff] 
                              bg-white 
                              focus:outline-none 
                              focus:ring-2 focus:ring-[#8b5cf6]"
                       placeholder="Enter role name"
                       required>
            </div>

            <!-- Permissions Section -->
            <div class="mb-8">

                <div class="flex justify-between items-center mb-4">
                    <label class="font-semibold text-gray-700">
                        Assign Permissions
                    </label>

                    <!-- Select All -->
                    <label class="flex items-center gap-2 cursor-pointer 
                                  bg-white border border-[#e9e7ff] 
                                  px-4 py-2 rounded-xl 
                                  hover:bg-[#ede9fe] transition">

                        <input type="checkbox"
                               id="selectAll"
                               class="w-4 h-4 text-[#8b5cf6] rounded 
                                      focus:ring-[#8b5cf6]">

                        <span class="text-sm font-medium text-[#8b5cf6]">
                            Select All
                        </span>
                    </label>
                </div>

                <!-- Permission Grid -->
                <div class="grid grid-cols-2 md:grid-cols-3 gap-4">

                    @foreach($permissions as $permission)
                    <label class="flex items-center gap-3 
                                  bg-white 
                                  border border-[#e9e7ff] 
                                  rounded-xl 
                                  px-4 py-3 
                                  hover:bg-[#ede9fe] 
                                  transition cursor-pointer">

                        <input type="checkbox"
                               name="permissions[]"
                               value="{{ $permission->name }}"
                               class="permission-checkbox w-4 h-4 
                                      text-[#8b5cf6] 
                                      rounded 
                                      focus:ring-[#8b5cf6]">

                        <span class="text-gray-700 text-sm font-medium">
                            {{ $permission->name }}
                        </span>

                    </label>
                    @endforeach

                </div>
            </div>

            <!-- Buttons -->
            <div class="flex items-center gap-4">

                <button type="submit"
                        class="bg-[#8b5cf6] hover:bg-[#7c3aed] 
                               text-white 
                               px-6 py-3 
                               rounded-xl 
                               shadow-md 
                               transition">
                    💾 Save Role
                </button>

                <a href="{{ route('admin.roles.index') }}"
                   class="px-6 py-3 
                          rounded-xl 
                          border border-[#e9e7ff] 
                          text-[#8b5cf6] 
                          hover:bg-[#ede9fe] 
                          transition">
                    Cancel
                </a>

            </div>

        </form>

    </div>

</div>

<!-- Select All Script -->
<script>
    const selectAll = document.getElementById('selectAll');
    const checkboxes = document.querySelectorAll('.permission-checkbox');

    // Select / Deselect All
    selectAll.addEventListener('change', function() {
        checkboxes.forEach(cb => cb.checked = this.checked);
    });

    // Auto update Select All if manually changed
    checkboxes.forEach(cb => {
        cb.addEventListener('change', function() {
            const allChecked = [...checkboxes].every(i => i.checked);
            selectAll.checked = allChecked;
        });
    });
</script>

@endsection
