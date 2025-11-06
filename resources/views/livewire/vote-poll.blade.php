<x-layout>
    <div class="max-w-2xl mx-auto bg-white rounded-xl shadow p-6 mt-6">
    <h2 class="text-2xl font-bold mb-4 text-gray-800">{{ $poll->title }}</h2>

    @if ($poll->description)
        <p class="text-gray-600 mb-4">{{ $poll->description }}</p>
    @endif

    {{-- Vote Message --}}
    @if ($voteMessage)
        <div class="mb-4 p-3 bg-green-100 text-green-800 rounded font-medium">
            {{ $voteMessage }}
        </div>
    @endif

    {{-- Voting Form --}}
    @if (!$hasVoted)
        <form wire:submit.prevent="vote" class="space-y-3">
            @foreach ($options as $option)
                <label
                    class="flex items-center justify-between p-3 border rounded-lg cursor-pointer hover:bg-indigo-50 transition">
                    <div class="flex items-center space-x-2">
                        <input type="radio" wire:model="selectedOption" value="{{ $option->id }}"
                            class="form-radio h-5 w-5 text-indigo-600">
                        <span class="text-gray-800 font-medium">{{ $option->option_text }}</span>
                    </div>
                </label>
            @endforeach
            <button type="submit" class="w-full bg-indigo-600 text-white py-2 rounded hover:bg-indigo-700 transition">
                Vote
            </button>
        </form>
    @endif

    {{-- Results --}}
    <h3 class="text-lg font-semibold mt-6 mb-3 text-gray-800">Live Results</h3>
    @php $totalVotes = max($options->sum('votes_count'),1); @endphp

    <div class="space-y-3">
        @foreach ($options as $option)
            @php
                $percentage = round(($option->votes_count / $totalVotes) * 100, 1);
                $colors = ['bg-indigo-600', 'bg-green-500', 'bg-yellow-400', 'bg-pink-500', 'bg-purple-500'];
                $color = $colors[$loop->index % count($colors)];
            @endphp
            <div>
                <div class="flex justify-between mb-1">
                    <span class="font-medium text-gray-700">{{ $option->option_text }}</span>
                    <span class="text-gray-600 text-sm">{{ $percentage }}%</span>
                </div>
                <div class="bg-gray-200 h-4 rounded-full">
                    <div class="{{ $color }} h-4 rounded-full transition-all duration-700"
                        style="width: {{ $percentage }}%"></div>
                </div>
            </div>
        @endforeach
    </div>

    <p class="text-gray-500 text-sm mt-2">Total Votes: {{ $totalVotes }}</p>
</div>
<script>
console.log("hel");

    Livewire.on('vote-success', (event) => {
console.log(event);

        alert(event);
        // Optional toast notification
        alert(event.message);
    });
</script>

</x-layout>
