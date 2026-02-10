<div class="bg-[#faf7f8] shadow-md px-6 py-4 flex items-center justify-between border-b border-[#f1dadd]">
    
    <!-- Left: Title -->
    <h1 class="text-xl font-semibold tracking-wide text-[#2f2f33]">
        Admin Panel
    </h1>

    <!-- Right: User + Logout -->
    <div class="flex items-center gap-4">
        
        <!-- User name badge -->
        <div class="bg-[#fde2e6] text-[#9f1239] px-4 py-2 rounded-full text-sm font-medium shadow-sm">
            {{ auth()->user()->name }}
        </div>

        <!-- Logout -->
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button
                type="submit"
                class="bg-[#2f2f33] text-white text-sm px-4 py-2 rounded-full shadow
                       hover:bg-[#9f1239] hover:shadow-lg
                       transition-all duration-200">
                Logout
            </button>
        </form>

    </div>
</div>
