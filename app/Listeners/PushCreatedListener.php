<?php

namespace App\Listeners;

use App\Events\PushCreated;
use ArtARTs36\PushAllSender\Interfaces\PusherInterface;

class PushCreatedListener
{
    public function handle(PushCreated $event)
    {
        $sender = app(PusherInterface::class);

        $sender->push($event->push->toSend());
    }
}
