<?php

namespace App\Livewire\Polls;

use App\Events\VoteUpdated;
use Livewire\Component;
use App\Models\Poll;
use App\Models\PollVote;
use App\Models\PollOption;
use Illuminate\Support\Str;
use Livewire\Attributes\Layout;

#[Layout('components.base-component')]
class VotePoll extends Component
{
    public $poll;
    public $options = [];
    public $selectedOption;
    public $hasVoted = false;
    public $voteMessage = '';
    protected $listeners = ['refreshPoll'];
    public $pollId;
    public function mount($pollId)
    {
        $this->pollId = $pollId;
        $this->poll = Poll::with('options')->findOrFail($pollId);
        $this->options = $this->poll->options;

        $ip = request()->ip();
        $deviceId = $this->getDeviceId();

        $this->hasVoted = PollVote::where('poll_id', $this->poll->id)
            ->where(function ($q) use ($ip, $deviceId) {
                $q->where('ip_address', $ip)
                    ->orWhere('device_id', $deviceId);
            })
            ->exists();

        // if ($this->hasVoted) {
        //     $this->voteMessage = 'You have already voted. Here are the live results.';
        //    $this->dispatch('vote-success',  $this->voteMessage);
        // }
    }

    public function getDeviceId()
    {
        // if (!session()->has('device_id')) {
        // }
        session(['device_id' => Str::uuid()->toString()]);
        return session('device_id');
    }

    public function vote()
    {
        // if ($this->hasVoted) {
        //     $this->voteMessage = 'You have already voted.';
        //     $this->dispatch('vote-success',  $this->voteMessage);
        //     return;
        // }

        // if (!$this->selectedOption) {
        //     $this->voteMessage = 'Please select an option before voting.';
        //     $this->dispatch('vote-success', $this->voteMessage);
        //     return;
        // }

        $ip = request()->ip();
        $deviceId = $this->getDeviceId();

        PollVote::create([
            'poll_id' => $this->poll->id,
            'option_id' => $this->selectedOption,
            'ip_address' => $ip,
            'device_id' => $deviceId,
        ]);

        PollOption::where('id', $this->selectedOption)->increment('votes_count');

        $this->hasVoted = true;
        $this->voteMessage = 'Thank you! Your vote has been recorded.';

        // Refresh options to show live results
        $this->options = $this->poll->fresh()->options;
        broadcast(new VoteUpdated($this->poll->id))->toOthers();

        // Notify user (Livewire 4)
        $this->dispatch('vote-success', 'Your vote has been successfully recorded!');
    }

    public function render()
    {
        return view('livewire.polls.vote-poll');
    }
    public function refreshPoll($pollId)
    {
        if ($this->poll->id == $pollId) {
            $this->poll->refresh();
            $this->options = $this->poll->options;
        }
    }
}
