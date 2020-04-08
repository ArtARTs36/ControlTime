<?php

namespace App\Listeners;

use App\Events\PushCreated;
use App\Senders\PushAllSender;

class PushCreatedListener
{
    public function handle(PushCreated $event)
    {
        $sender = new PushAllSender();

        $sender->push($event->push->title, $event->push->message);
    }
}
