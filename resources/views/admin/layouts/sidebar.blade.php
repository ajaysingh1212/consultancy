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

    <ul class="px-3 py-4 space-y-3 text-sm">

        <!-- Dashboard -->
        <li>
            <a href="{{ route('admin.dashboard') }}"
               class="flex items-center gap-3 px-4 py-2 rounded-xl transition
               {{ str_contains($route,'dashboard')
                    ? 'bg-[#9f1239] text-white'
                    : 'text-[#2f2f33] hover:bg-[#fde2e6]' }}">
                📊 Dashboard
            </a>
        </li>

        <!-- USER MANAGEMENT -->
        @canany(['user.view','role.view','permission.view'])
        <li>
            <button onclick="toggleMenu('userMgmt')"
                class="w-full flex items-center justify-between px-4 py-2 rounded-xl transition
                {{ $userMgmtActive
                    ? 'bg-[#9f1239] text-white'
                    : 'text-[#2f2f33] hover:bg-[#fde2e6]' }}">
                <span class="flex items-center gap-3">👥 User Management</span>
                <span id="userMgmtIcon">{{ $userMgmtActive ? '▾' : '▸' }}</span>
            </button>

            <!-- Child Card -->
            <div id="userMgmt" class="{{ $userMgmtActive ? '' : 'hidden' }} mt-2 ml-2">
                <div class="bg-[#fff1f3] rounded-2xl p-2 border border-[#f1dadd] space-y-1">

                    <a href="{{ route('admin.permissions.index') }}"
                       class="block px-4 py-2 rounded-lg transition
                       {{ str_contains($route,'permissions')
                            ? 'bg-white text-[#9f1239] font-medium'
                            : 'text-[#2f2f33] hover:bg-[#fde2e6]' }}">
                        🔑 Permissions
                    </a>

                    <a href="{{ route('admin.roles.index') }}"
                       class="block px-4 py-2 rounded-lg transition
                       {{ str_contains($route,'roles')
                            ? 'bg-white text-[#9f1239] font-medium'
                            : 'text-[#2f2f33] hover:bg-[#fde2e6]' }}">
                        🛡 Roles
                    </a>

                    <a href="{{ route('admin.users.index') }}"
                       class="block px-4 py-2 rounded-lg transition
                       {{ str_contains($route,'users')
                           ? 'bg-white text-[#9f1239] font-medium'
                            : 'text-[#2f2f33] hover:bg-[#fde2e6]' }}">
                        👤 Users
                    </a>

                </div>
            </div>
        </li>
        @endcanany

        <!-- CANDIDATE MANAGEMENT -->
       @canany(['candidate.view','candidate.verify'])
        <li>
            <button onclick="toggleMenu('candidateMgmt')"
                class="w-full flex items-center justify-between px-4 py-2 rounded-xl transition
                {{ $candidateActive
                    ? 'bg-[#9f1239] text-white'
                    : 'text-[#2f2f33] hover:bg-[#fde2e6]' }}">
                <span class="flex items-center gap-3">🧑‍💼 Candidate Management</span>
                <span id="candidateMgmtIcon">{{ $candidateActive ? '▾' : '▸' }}</span>
            </button>

            <!-- Child Card -->
              <div id="candidateMgmt" class="{{ $candidateActive ? '' : 'hidden' }} mt-2 ml-2">
                <div class="bg-[#fff1f3] rounded-2xl p-2 border border-[#f1dadd] space-y-1">

                    <a href="{{ route('admin.candidates.index') }}"
                       class="block px-4 py-2 rounded-lg transition
                       {{ str_contains($route,'candidates')
                            ? 'bg-[#9f1239] text-white'
                    : 'text-[#2f2f33] hover:bg-[#fde2e6]' }}">
                        📋 All Candidates
                    </a>

                    <a href="{{ route('admin.candidate.verification.index') }}"
                       class="block px-4 py-2 rounded-lg transition
                       {{ str_contains($route,'candidate-kyc')
                             ? 'bg-[#9f1239] text-white'
                    : 'text-[#2f2f33] hover:bg-[#fde2e6]' }}">
                        🪪 KYC Details
                    </a>

                    <a href="{{ route('admin.candidate.verification.index') }}"
                       class="block px-4 py-2 rounded-lg transition
                       {{ str_contains($route,'candidate-documents')
                             ? 'bg-[#9f1239] text-white'
                    : 'text-[#2f2f33] hover:bg-[#fde2e6]' }}">
                        📂 Documents
                    </a>

                    <a href="{{ route('admin.candidate.verification.index') }}"
                       class="block px-4 py-2 rounded-lg transition
                       {{ str_contains($route,'candidate-verification')
                           ? 'bg-[#9f1239] text-white'
                    : 'text-[#2f2f33] hover:bg-[#fde2e6]' }}">
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
