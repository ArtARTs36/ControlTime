<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Query\Builder;
use ArtARTs36\PushAllSender\Push as Message;

/**
 * Class Push
 * @property int $id
 * @property string $title
 * @property string $message
 *
 * @mixin Builder
 */
class Push extends Model
{
    /**
     * @return Message
     */
    public function toSend(): Message
    {
        return new Message($this->title, $this->message);
    }
}
