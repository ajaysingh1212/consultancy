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

    $walletActive =
        str_contains($route, 'wallets');


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
                    @can('candidate.skill.view')
                        <a href="{{ route('admin.candidate-skills.index') }}"
                        class="block px-4 py-2 rounded-lg transition
                        {{ str_contains($route,'candidate-skills')
                                ? 'bg-[#9f1239] text-white'
                                : 'text-[#2f2f33] hover:bg-[#fde2e6]' }}">
                            🧠 Candidate Skills
                        </a>
                    @endcan

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
        @canany(['wallet.view','wallet.manage'])
        <li>
            <button onclick="toggleMenu('walletMgmt')"
                class="w-full flex items-center justify-between px-4 py-2 rounded-xl transition
                {{ $walletActive
                    ? 'bg-[#9f1239] text-white'
                    : 'text-[#2f2f33] hover:bg-[#fde2e6]' }}">
                <span class="flex items-center gap-3">💰 Wallet Management</span>
                <span id="walletMgmtIcon">{{ $walletActive ? '▾' : '▸' }}</span>
            </button>

            <div id="walletMgmt" class="{{ $walletActive ? '' : 'hidden' }} mt-2 ml-2">
                <div class="bg-[#fff1f3] rounded-2xl p-2 border border-[#f1dadd] space-y-1">
                    <a href="{{ route('admin.wallets.index') }}"
                    class="block px-4 py-2 rounded-lg transition
                    {{ str_contains($route,'wallets')
                            ? 'bg-white text-[#9f1239] font-medium'
                            : 'text-[#2f2f33] hover:bg-[#fde2e6]' }}">
                        💰 All Wallets
                    </a>



                    <a href="#"
                    class="block px-4 py-2 rounded-lg transition
                    {{ str_contains($route,'wallet-report')
                            ? 'bg-white text-[#9f1239] font-medium'
                            : 'text-[#2f2f33] hover:bg-[#fde2e6]' }}">
                        📊 Wallet Reports
                    </a>

                </div>
            </div>
        </li>
        @endcanany
        @canany(['wallet.view','wallet.manage'])
            <li>
                <button onclick="toggleMenu('walletMgmts')"
                    class="w-full flex items-center justify-between px-4 py-2 rounded-xl transition
                    {{ $walletActive
                        ? 'bg-[#9f1239] text-white'
                        : 'text-[#2f2f33] hover:bg-[#fde2e6]' }}">
                    <span class="flex items-center gap-3">💰 Expance Mangement</span>
                    <span id="walletMgmtIcon">{{ $walletActive ? '▾' : '▸' }}</span>
                </button>

                <div id="walletMgmts" class="{{ $walletActive ? '' : 'hidden' }} mt-2 ml-2">
                    <div class="bg-[#fff1f3] rounded-2xl p-2 border border-[#f1dadd] space-y-1">

                        @can('expense.category.view')
                        <a href="{{ route('admin.expensecategory.index') }}"
                            class="block px-4 py-2 rounded-lg transition">
                            📂 Expense Categories
                        </a>
                        @endcan

                        @can('expense.view')
                        <a href="{{ route('admin.expenses.index') }}"
                            class="block px-4 py-2 rounded-lg transition">
                            🧾 Record Expense
                        </a>
                        @endcan



                    </div>
                </div>
            </li>
            @endcanany
            @php
                $route = request()->route()->getName();
                $isSuper = auth()->user()->hasRole(['Super Admin','Admin']);
            @endphp
            {{-- EMPLOYER MANAGEMENT --}}
            @if($isSuper || auth()->user()->canany(['employer.view','job.view']))
            <li>
                <button onclick="toggleMenu('employerMgmt')"
                    class="w-full flex justify-between px-4 py-2 rounded-xl hover:bg-[#fde2e6]">
                    🏢 Employer Management
                    <span id="employerMgmtIcon">▸</span>
                </button>

                <div id="employerMgmt" class="hidden mt-2 ml-2">
                    <div class="bg-[#fff1f3] rounded-xl p-2 space-y-1">

                        @if($isSuper || auth()->user()->can('employer.view'))
                        <a href="{{ route('admin.employers.index') }}"
                        class="block px-3 py-2 rounded-lg hover:bg-[#fde2e6]">
                            🏢 Employers
                        </a>
                        @endif

                        @if($isSuper || auth()->user()->can('job.view'))
                        <a href="{{ route('admin.jobs.index') }}"
                        class="block px-3 py-2 rounded-lg hover:bg-[#fde2e6]">
                            💼 Jobs
                        </a>
                        @endif

                        @if($isSuper || auth()->user()->can('application.view'))
                        <a href="{{ route('admin.applications.index') }}"
                        class="block px-3 py-2 rounded-lg hover:bg-[#fde2e6]">
                            📄 Applications
                        </a>
                        @endif

                    </div>
                </div>
            </li>
            @endif


            {{-- SKILL MANAGEMENT --}}
            @if($isSuper || auth()->user()->can('skill.manage'))
            <li>
                <a href="{{ route('admin.skills.index') }}"
                class="flex px-4 py-2 rounded-xl hover:bg-[#fde2e6]">
                    🧠 Skills
                </a>
            </li>
            @endif


            {{-- SUBSCRIPTION --}}
            @if($isSuper || auth()->user()->can('subscription.manage'))
            <li>
                <a href="{{ route('admin.plans.index') }}"
                class="flex px-4 py-2 rounded-xl hover:bg-[#fde2e6]">
                    💳 Subscription Plans
                </a>
            </li>
            @endif
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
