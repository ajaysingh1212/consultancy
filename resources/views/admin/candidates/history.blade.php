<div class="relative border-l-2 border-gray-200 pl-6 space-y-6">

@foreach($histories as $history)
    <div class="relative">

        <div class="absolute -left-3 top-1 w-5 h-5
            @if($history->status=='verified') bg-green-500
            @elseif($history->status=='rejected') bg-red-500
            @else bg-yellow-500 @endif
            rounded-full border-4 border-white shadow">
        </div>

        <div class="bg-gray-50 p-4 rounded shadow-sm">
            <div class="flex justify-between text-xs text-gray-500">
                <span>{{ $history->user->name ?? 'System' }}</span>
                <span>{{ $history->created_at->format('d M Y h:i A') }}</span>
            </div>

            <div class="mt-2 text-sm">
                Status changed to:
                <strong>{{ ucfirst($history->status) }}</strong>
            </div>

            @if($history->remarks)
                <div class="text-xs text-red-600 mt-1">
                    Remark: {{ $history->remarks }}
                </div>
            @endif
        </div>

    </div>
@endforeach

</div>
