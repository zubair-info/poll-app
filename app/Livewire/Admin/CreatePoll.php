<?php
namespace App\Livewire\Admin;

use Livewire\Component;
use App\Models\Poll;
use App\Models\PollOption;

class CreatePoll extends Component
{
    public $title;
    public $description;
    public $options = ['']; // প্রথমে একটি অপশন
    public $starts_at;
    public $ends_at;

    protected $rules = [
        'title' => 'required|string|max:255',
        'description' => 'nullable|string',
        'options.*' => 'required|string|max:255',
        'starts_at' => 'nullable|date',
        'ends_at' => 'nullable|date|after:starts_at',
    ];

    public function addOption()
    {
        $this->options[] = '';
    }

    public function removeOption($index)
    {
        unset($this->options[$index]);
        $this->options = array_values($this->options);
    }

    public function save()
    {
        $this->validate();

        $poll = Poll::create([
            'title' => $this->title,
            'description' => $this->description,
            'starts_at' => $this->starts_at,
            'ends_at' => $this->ends_at,
            'is_active' => true,
        ]);

        foreach ($this->options as $text) {
            PollOption::create([
                'poll_id' => $poll->id,
                'option_text' => $text,
            ]);
        }

        $this->reset(['title', 'description', 'options', 'starts_at', 'ends_at']);
        $this->options = [''];

        // $this->emit('pollCreated'); // ManagePolls কম্পোনেন্ট রিফ্রেশ করবে
        $this->dispatch('pollCreated');

        session()->flash('message', 'Poll created successfully!');
    }

    public function render()
    {
        return view('livewire.admin.create-poll');
    }
}
