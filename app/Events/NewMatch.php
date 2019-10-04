<?php

namespace App\Events;

use App\Chat;
use App\Profile;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class NewMatch implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $chat;
    public $partner;

    /**
     * Create a new event instance.
     *
     * @param Chat $chat
     */
    public function __construct(Chat $chat){
        $this->chat = $chat;
        $this->partner = $chat->partner()->first()->id;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return new PrivateChannel('matches.' . $this->partner);
    }

    public function broadcastWith(){
        $newMatch = $this->chat;
        $newMatch->type = 'New match';
        return ["match" => $newMatch];
    }
}
