<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class VoteUpdated implements ShouldBroadcast
{
    use InteractsWithSockets, SerializesModels;

    public $pollId;

    public function __construct($pollId)
    {
        $this->pollId = $pollId;
    }

    public function broadcastOn()
    {
        return new Channel('poll.' . $this->pollId);
    }

    public function broadcastWith()
    {
        return [
            'poll_id' => $this->pollId,
        ];
    }
}
