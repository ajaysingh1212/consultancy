@php
    $route = request()->route()->getName();
    $userMgmtActive = str_contains($route, 'users')
        || str_contains($route, 'roles')
        || str_contains($route, 'permissions');
@endphp
@php
    $candidateActive =
        str_contains($route, 'candidates')
        || str_contains($route, 'candidate-kyc')
        || str_contains($route, 'candidate-documents')
        || str_contains($route, 'candidate-verification');
@endphp

<div class="w-64 bg-gray-800 text-white min-h-screen">
    <div class="p-4 font-bold text-lg border-b border-gray-700">
        Admin Panel
    </div>

    <ul class="mt-4 space-y-1">

        {{-- Dashboard --}}
        <li>
            <a href="{{ route('admin.dashboard') }}"
               class="block px-4 py-2 rounded
               {{ str_contains($route,'dashboard') ? 'bg-blue-600' : 'hover:bg-gray-700' }}">
                📊 Dashboard
            </a>
        </li>

        {{-- User Management --}}
        @canany(['user.view','role.view','permission.view'])
        <li>
            <button
                class="w-full text-left px-4 py-2 flex justify-between items-center
                {{ $userMgmtActive ? 'bg-gray-700' : 'hover:bg-gray-700' }}"
                onclick="toggleMenu('userMgmt')">

                👥 User Management
                <span id="userMgmtIcon">
                    {{ $userMgmtActive ? '▾' : '▸' }}
                </span>
            </button>

            <ul id="userMgmt"
                class="ml-4 mt-1 space-y-1 {{ $userMgmtActive ? '' : 'hidden' }}">

                @can('permission.view')
                <li>
                    <a href="{{ route('admin.permissions.index') }}"
                       class="block px-4 py-2 rounded
                       {{ str_contains($route,'permissions') ? 'bg-blue-600' : 'hover:bg-gray-700' }}">
                        🔑 Permissions
                    </a>
                </li>
                @endcan

                @can('role.view')
                <li>
                    <a href="{{ route('admin.roles.index') }}"
                       class="block px-4 py-2 rounded
                       {{ str_contains($route,'roles') ? 'bg-blue-600' : 'hover:bg-gray-700' }}">
                        🛡 Roles
                    </a>
                </li>
                @endcan

                @can('user.view')
                <li>
                    <a href="{{ route('admin.users.index') }}"
                       class="block px-4 py-2 rounded
                       {{ str_contains($route,'users') ? 'bg-blue-600' : 'hover:bg-gray-700' }}">
                        👤 Users
                    </a>
                </li>
                @endcan

            </ul>
        </li>
        @endcanany
        {{-- Candidate Management --}}
        @canany([
            'candidate.view',
            'candidate.create',
            'candidate.verify'
        ])
        <li>
            <button
                class="w-full text-left px-4 py-2 flex justify-between items-center
                {{ $candidateActive ? 'bg-gray-700' : 'hover:bg-gray-700' }}"
                onclick="toggleMenu('candidateMgmt')">

                🧑‍💼 Candidate Management
                <span id="candidateMgmtIcon">
                    {{ $candidateActive ? '▾' : '▸' }}
                </span>
            </button>

            <ul id="candidateMgmt"
                class="ml-4 mt-1 space-y-1 {{ $candidateActive ? '' : 'hidden' }}">

                {{-- Candidate List --}}
                @can('candidate.view')
                <li>
                    <a href="{{ route('admin.candidates.index') }}"
                    class="block px-4 py-2 rounded
                    {{ str_contains($route,'candidates') ? 'bg-blue-600' : 'hover:bg-gray-700' }}">
                        📋 All Candidates
                    </a>
                </li>
                @endcan

                {{-- KYC Details --}}
                @can('candidate.verify')
                <li>
                    <a href="{{ route('admin.candidate.verification.index') }}"
                    class="block px-4 py-2 rounded
                    {{ str_contains($route,'candidate-kyc') ? 'bg-blue-600' : 'hover:bg-gray-700' }}">
                        🪪 KYC Details
                    </a>
                </li>
                @endcan

                {{-- Documents --}}
                @can('candidate.verify')
                <li>
                    <a href="{{ route('admin.candidate.verification.index') }}"
                    class="block px-4 py-2 rounded
                    {{ str_contains($route,'candidate-documents') ? 'bg-blue-600' : 'hover:bg-gray-700' }}">
                        📂 Documents
                    </a>
                </li>
                @endcan

                {{-- Verification --}}
                @can('candidate.verify')
                <li>
                    <a href="{{ route('admin.candidate.verification.index') }}"
                    class="block px-4 py-2 rounded
                    {{ str_contains($route,'candidate-verification') ? 'bg-blue-600' : 'hover:bg-gray-700' }}">
                        ✅ Verification Status
                    </a>
                </li>
                @endcan

            </ul>
        </li>
        @endcanany


    </ul>
</div>

{{-- Simple toggle script --}}
<script>
    function toggleMenu(id) {
        const el = document.getElementById(id);
        const icon = document.getElementById(id + 'Icon');

        el.classList.toggle('hidden');
        icon.innerText = el.classList.contains('hidden') ? '▸' : '▾';
    }
</script>
