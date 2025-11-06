    <div class="max-w-lg mx-auto p-6 bg-white shadow rounded-xl">
    <h2 class="text-xl font-bold mb-4">{{ $poll->title }}</h2>
    <p class="mb-4 text-gray-600">{{ $poll->description }}</p>

    @foreach ($poll->options as $option)
        <label class="flex items-center space-x-2 mb-2">
            <input type="radio" wire:model="selectedOption" value="{{ $option->id }}">
            <span>{{ $option->option_text }}</span>
        </label>
    @endforeach

    <button wire:click="vote" class="bg-blue-600 text-white px-4 py-2 rounded mt-3">
        Submit Vote
    </button>

    @if (session('success'))
        <p class="text-green-600 mt-3">{{ session('success') }}</p>
    @endif

    @if (session('error'))
        <p class="text-red-600 mt-3">{{ session('error') }}</p>
    @endif

    <div class="mt-6 border-t pt-4">
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


{{-- <x-slot name="script"> --}}
      @livewireScripts

    <script>
    console.log("Hello")
    
    Livewire.on('vote-success', (event) => {
        console.log(event);
        
        alert(event);
    });
</script>
{{-- </x-slot> --}}
