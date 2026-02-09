<div class="bg-white shadow px-6 py-4 flex justify-between">
    <h1 class="font-bold">Admin Panel</h1>

    <div>
        {{ auth()->user()->name }}
        <form method="POST" action="{{ route('logout') }}" class="inline">
            @csrf
            <button class="ml-4 text-red-600">Logout</button>
        </form>
    </div>
</div>
