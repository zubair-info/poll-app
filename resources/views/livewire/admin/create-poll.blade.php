<div class="mb-6 bg-white p-6 rounded-lg shadow">
    <h3 class="text-lg font-bold mb-4">Create New Poll</h3>

    @if (session()->has('message'))
        <div class="bg-green-100 text-green-700 p-2 rounded mb-4">
            {{ session('message') }}
        </div>
    @endif

    <div class="space-y-4">
        <input type="text" wire:model="title" placeholder="Poll Title" class="w-full border p-2 rounded">
        <textarea wire:model="description" placeholder="Description" class="w-full border p-2 rounded"></textarea>

        <div>
            <label class="font-semibold mb-2 block">Poll Options:</label>
            @foreach ($options as $index => $option)
                <div class="flex items-center mb-2 space-x-2">
                    <input type="text" wire:model="options.{{ $index }}" placeholder="Option text"
                        class="flex-1 border p-2 rounded">
                    <button type="button" wire:click="removeOption({{ $index }})"
                        class="bg-red-500 text-white px-2 py-1 rounded">✕</button>
                </div>
            @endforeach
            <button type="button" wire:click="addOption" class="text-blue-500 text-sm mt-1">+ Add another
                option</button>
        </div>

        <div class="grid grid-cols-2 gap-4">
            <input type="datetime-local" wire:model="starts_at" class="border p-2 rounded">
            <input type="datetime-local" wire:model="ends_at" class="border p-2 rounded">
        </div>

        <button type="button" wire:click="save" class="bg-green-600 text-white px-4 py-2 rounded mt-3">Save
            Poll</button>
    </div>
</div>
