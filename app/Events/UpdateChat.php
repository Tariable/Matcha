<?php

namespace App\Events;

use App\Chat;
use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class UpdateChat implements ShouldBroadcast
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
    public function broadcastOn(){
        return new PrivateChannel('chats.' . $this->partner);
    }

    public function broadcastWith(){
        $currentChat = $this->chat;
        $currentChat->partner = $this->chat->partner()->first();
        $currentChat->message = $this->chat->messagesReverse()->first();
        $currentChat->unread = $this->chat->unreadMessages()->count();
        return ["chat" => $this->chat];
    }
}
