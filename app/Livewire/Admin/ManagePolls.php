<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use App\Models\Poll;

class ManagePolls extends Component
{
    public $polls;

    protected $listeners = ['pollCreated' => 'loadPolls'];

    public function mount()
    {
        $this->loadPolls();
    }

    public function loadPolls()
    {
        $this->polls = Poll::withCount('votes')
            ->with('options')
            ->orderBy('created_at', 'desc')
            ->get();
    }

    public function toggleActive($pollId)
    {
        $poll = Poll::findOrFail($pollId);
        $poll->is_active = !$poll->is_active;
        $poll->save();

        $this->loadPolls();
        session()->flash('message', 'Poll status updated.');
    }

    public function deletePoll($pollId)
    {
        Poll::findOrFail($pollId)->delete();
        $this->loadPolls();
        session()->flash('message', 'Poll deleted successfully.');
    }

    public function render()
    {
        $polls = Poll::with('options')->latest()->get();

        return view('livewire.admin.manage-polls', [
            'polls' => $polls,
        ]); // 👈 use your existing layout
    }
}
