<div id="rejectModal{{ $doc->id }}"
     class="fixed inset-0 bg-black bg-opacity-50 hidden items-center justify-center">

    <form method="POST"
          action="{{ route('admin.candidate.document.verify',$doc) }}"
          class="bg-white p-6 rounded w-96">
        @csrf

        <input type="hidden" name="status" value="rejected">

        <h3 class="font-bold mb-3">Reject Document</h3>

        <textarea name="remarks"
                  class="border p-2 w-full"
                  placeholder="Enter rejection reason"
                  required></textarea>

        <div class="flex justify-end gap-2 mt-4">
            <button type="button"
                    onclick="closeReject({{ $doc->id }})"
                    class="px-3 py-1 bg-gray-400 rounded">
                Cancel
            </button>

            <button class="px-3 py-1 bg-red-600 text-white rounded">
                Reject
            </button>
        </div>
    </form>
</div>
