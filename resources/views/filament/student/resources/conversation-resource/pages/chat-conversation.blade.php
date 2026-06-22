<x-filament-panels::page>
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-4">
        <div class="flex items-center gap-3 mb-4 pb-4 border-b border-gray-100">
            <div class="w-10 h-10 rounded-full bg-primary-100 flex items-center justify-center">
                <span class="text-primary-700 font-semibold text-sm">
                    {{ substr($conversation->teacher->user->name, 0, 1) }}
                </span>
            </div>
            <div>
                <p class="font-medium text-gray-900">{{ $conversation->teacher->user->name }}</p>
                <p class="text-sm text-gray-500">{{ $conversation->course->name }}</p>
            </div>
        </div>

        <div class="space-y-3 max-h-96 overflow-y-auto px-2">
            @forelse($messages as $msg)
                <div class="flex {{ $msg['sender_id'] === auth()->id() ? 'justify-end' : 'justify-start' }}">
                    <div class="max-w-[75%] rounded-lg px-4 py-2 {{ $msg['sender_id'] === auth()->id() ? 'bg-primary-500 text-white' : 'bg-gray-100 text-gray-900' }}">
                        <p class="text-sm">{{ $msg['message'] }}</p>
                        <p class="text-xs mt-1 {{ $msg['sender_id'] === auth()->id() ? 'text-primary-100' : 'text-gray-500' }}">
                            {{ \Carbon\Carbon::parse($msg['created_at'])->format('H:i, d M Y') }}
                        </p>
                    </div>
                </div>
            @empty
                <p class="text-center text-gray-400 py-8">Belum ada pesan. Mulai percakapan dengan mengirim pesan pertama.</p>
            @endforelse
        </div>
    </div>
</x-filament-panels::page>
