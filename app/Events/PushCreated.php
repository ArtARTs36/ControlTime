<?php

namespace App\Events;

use App\Models\Push;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class PushCreated
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $push;

    public function __construct(Push $push)
    {
        $this->push = $push;
    }

    public function broadcastOn()
    {
        return new PrivateChannel('channel-name');
    }
}
