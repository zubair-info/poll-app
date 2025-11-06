<div class="p-6 max-w-7xl mx-auto">
    <h2 class="text-2xl font-bold mb-6">Manage Polls</h2>

    {{-- Success message --}}
    @if (session()->has('message'))
        <div class="bg-green-100 text-green-700 p-2 rounded mb-4">
            {{ session('message') }}
        </div>
    @endif
    <livewire:admin.create-poll  />
    {{-- Poll Table --}}
    <div class="overflow-x-auto bg-white shadow rounded-lg">
        <table class="min-w-full border">
            <thead>
                <tr class="bg-gray-100 text-left">
                    <th class="px-4 py-2">Title</th>
                    <th class="px-4 py-2">Options</th>
                    <th class="px-4 py-2">Votes</th>
                    <th class="px-4 py-2">Status</th>
                    <th class="px-4 py-2 text-right">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($polls as $poll)
                    <tr class="border-t hover:bg-gray-50">
                        <td class="px-4 py-2 font-semibold">{{ $poll->title }}</td>
                        <td class="px-4 py-2">
                            @foreach ($poll->options as $option)
                                <span class="bg-gray-100 px-2 py-1 rounded text-sm">{{ $option->option_text }}</span>
                            @endforeach
                        </td>
                        <td class="px-4 py-2">{{ $poll->votes_count }}</td>
                        <td class="px-4 py-2">
                            @if ($poll->is_active)
                                <span class="text-green-600 font-semibold">Active</span>
                            @else
                                <span class="text-red-600 font-semibold">Inactive</span>
                            @endif
                        </td>
                        <td class="px-4 py-2 text-right space-x-2">
                            <button wire:click="toggleActive({{ $poll->id }})"
                                class="bg-blue-500 hover:bg-blue-600 text-white px-3 py-1 rounded text-sm">
                                {{ $poll->is_active ? 'Deactivate' : 'Activate' }}
                            </button>
                            <button wire:click="deletePoll({{ $poll->id }})"
                                class="bg-red-500 hover:bg-red-600 text-white px-3 py-1 rounded text-sm"
                                onclick="return confirm('Are you sure you want to delete this poll?')">
                                Delete
                            </button>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="px-4 py-2 text-center text-gray-500">
                            No polls found.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
