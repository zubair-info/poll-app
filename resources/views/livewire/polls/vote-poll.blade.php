<div class="max-w-lg mx-auto p-6 bg-white shadow rounded-xl">
    <h2 class="text-xl font-bold mb-4">{{ $poll->title }}</h2>
    <p class="mb-4 text-gray-600">{{ $poll->description }}</p>

    {{-- Poll options --}}
    @foreach ($poll->options as $option)
        <label class="flex items-center space-x-2 mb-2">
            <input type="radio" wire:model="selectedOption" value="{{ $option->id }}">
            <span>{{ $option->option_text }}</span>
        </label>
    @endforeach

    {{-- Submit button --}}
    <button wire:click="vote" class="bg-blue-600 text-white px-4 py-2 rounded mt-3">
        Submit Vote
    </button>

    {{-- Messages --}}
    @if ($voteMessage)
        <p class="text-green-600 mt-3">{{ $voteMessage }}</p>
    @endif

    {{-- Live results --}}
    <div wire:ignore>
        <div id="poll-results" class="mt-6">
            <h3 class="font-semibold mb-2">Live Results</h3>
            @php $total = max($poll->options->sum('votes_count'), 1); @endphp
            @foreach ($poll->options as $option)
                @php $percent = round(($option->votes_count / $total) * 100, 1); @endphp
                <div class="mb-2">
                    <div class="flex justify-between text-sm">
                        <span>{{ $option->option_text }}</span>
                        <span>{{ $percent }}%</span>
                    </div>
                    <div class="h-2 bg-gray-200 rounded">
                        <div class="h-2 bg-blue-500 rounded" style="width: {{ $percent }}%"></div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</div>

{{-- Scripts --}}
@livewireScripts
<script src="https://js.pusher.com/8.2.0/pusher.min.js"></script>
<script>
    console.log("Hello");

    // Listen for success message
    Livewire.on('vote-success', (message) => {
        alert(message);
    });

    // Setup Pusher listener for real-time updates
    Pusher.logToConsole = true;

    const pusher = new Pusher("{{ env('PUSHER_APP_KEY') }}", {
        cluster: "{{ env('PUSHER_APP_CLUSTER') }}",
        forceTLS: true
    });

    const channel = pusher.subscribe('poll.{{ $poll->id }}');
    channel.bind('App\\Events\\VoteUpdated', function(data) {
        Livewire.emit('refreshPoll', data.poll_id);
    });
</script>
