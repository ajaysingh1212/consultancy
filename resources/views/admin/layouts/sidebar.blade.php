@php
    $route = request()->route()->getName();

    $userMgmtActive =
        str_contains($route, 'users') ||
        str_contains($route, 'roles') ||
        str_contains($route, 'permissions');

    $candidateActive =
        str_contains($route, 'candidates') ||
        str_contains($route, 'candidate-kyc') ||
        str_contains($route, 'candidate-documents') ||
        str_contains($route, 'candidate-verification');
@endphp

<div class="w-64 min-h-screen bg-[#faf7f8] border-r border-[#f1dadd]">

    <!-- Header -->
    <div class="px-6 py-4 text-lg font-semibold text-[#2f2f33] border-b border-[#f1dadd]">
        Admin Panel
    </div>

    <ul class="px-3 py-4 space-y-3 text-sm text-[#2f2f33]">

        <!-- Dashboard -->
        <li>
            <a href="{{ route('admin.dashboard') }}"
               class="flex items-center gap-3 px-4 py-2 rounded-xl transition
               {{ str_contains($route,'dashboard')
                    ? 'bg-[#9f1239] text-white shadow-md'
                    : 'hover:bg-[#fde2e6]' }}">
                📊 Dashboard
            </a>
        </li>

        <!-- USER MANAGEMENT CARD -->
        @canany(['user.view','role.view','permission.view'])
        <li class="rounded-2xl border transition
            {{ $userMgmtActive ? 'border-[#9f1239] bg-[#fff1f3] shadow-md' : 'border-transparent' }}">

            <!-- Parent -->
            <button onclick="toggleMenu('userMgmt')"
                class="w-full flex items-center justify-between px-4 py-3 rounded-2xl transition
                {{ $userMgmtActive
                    ? 'bg-[#9f1239] text-white'
                    : 'hover:bg-[#fde2e6]' }}">

                <span class="flex items-center gap-3 font-medium">
                    👥 User Management
                </span>
                <span id="userMgmtIcon">
                    {{ $userMgmtActive ? '▾' : '▸' }}
                </span>
            </button>

            <!-- Child Card -->
            <div id="userMgmt"
                 class="{{ $userMgmtActive ? '' : 'hidden' }} px-3 pb-3 pt-2">

                <div class="bg-white rounded-xl p-2 space-y-1 border border-[#f1dadd]">

                    <a href="{{ route('admin.permissions.index') }}"
                       class="block px-4 py-2 rounded-lg transition
                       {{ str_contains($route,'permissions')
                            ? 'bg-[#fde2e6] text-[#9f1239] font-medium'
                            : 'hover:bg-[#fff1f3]' }}">
                        🔑 Permissions
                    </a>

                    <a href="{{ route('admin.roles.index') }}"
                       class="block px-4 py-2 rounded-lg transition
                       {{ str_contains($route,'roles')
                            ? 'bg-[#fde2e6] text-[#9f1239] font-medium'
                            : 'hover:bg-[#fff1f3]' }}">
                        🛡 Roles
                    </a>

                    <a href="{{ route('admin.users.index') }}"
                       class="block px-4 py-2 rounded-lg transition
                       {{ str_contains($route,'users')
                            ? 'bg-[#fde2e6] text-[#9f1239] font-medium'
                            : 'hover:bg-[#fff1f3]' }}">
                        👤 Users
                    </a>

                </div>
            </div>
        </li>
        @endcanany

        <!-- CANDIDATE MANAGEMENT CARD -->
        @canany(['candidate.view','candidate.verify'])
        <li class="rounded-2xl border transition
            {{ $candidateActive ? 'border-[#9f1239] bg-[#fff1f3] shadow-md' : 'border-transparent' }}">

            <button onclick="toggleMenu('candidateMgmt')"
                class="w-full flex items-center justify-between px-4 py-3 rounded-2xl transition
                {{ $candidateActive
                    ? 'bg-[#9f1239] text-white'
                    : 'hover:bg-[#fde2e6]' }}">

                <span class="flex items-center gap-3 font-medium">
                    🧑‍💼 Candidate Management
                </span>
                <span id="candidateMgmtIcon">
                    {{ $candidateActive ? '▾' : '▸' }}
                </span>
            </button>

            <div id="candidateMgmt"
                 class="{{ $candidateActive ? '' : 'hidden' }} px-3 pb-3 pt-2">

                <div class="bg-white rounded-xl p-2 space-y-1 border border-[#f1dadd]">

                    <a href="{{ route('admin.candidates.index') }}"
                       class="block px-4 py-2 rounded-lg transition
                       {{ str_contains($route,'candidates')
                            ? 'bg-[#fde2e6] text-[#9f1239] font-medium'
                            : 'hover:bg-[#fff1f3]' }}">
                        📋 All Candidates
                    </a>

                    <a href="{{ route('admin.candidate.verification.index') }}"
                       class="block px-4 py-2 rounded-lg transition
                       {{ str_contains($route,'candidate-verification')
                            ? 'bg-[#fde2e6] text-[#9f1239] font-medium'
                            : 'hover:bg-[#fff1f3]' }}">
                        ✅ Verification Status
                    </a>

                </div>
            </div>
        </li>
        @endcanany

    </ul>
</div>

<script>
    function toggleMenu(id) {
        const el = document.getElementById(id);
        const icon = document.getElementById(id + 'Icon');
        el.classList.toggle('hidden');
        icon.innerText = el.classList.contains('hidden') ? '▸' : '▾';
    }
</script>
