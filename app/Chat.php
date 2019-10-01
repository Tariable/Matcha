<?php

namespace App;

use App\Pivots\Subscription;
use App\Traits\IdFunctions;
use Illuminate\Database\Eloquent\Model;

class Chat extends Model
{
    use IdFunctions;

    protected   $guarded = [];
    public      $chatIdArray = [];

    public function profiles(){
        return $this->belongsToMany(Profile::class, 'subscription')->using(Subscription::class);
    }

    public function partner(){
        return $this->belongsToMany(Profile::class, 'subscription')->where('id', '!=',  auth()->id());
    }

    public function unreadMessages(){
        return $this->messages()->where(['read' => '0', 'to' => auth()->id()]);
    }

    public function chats(){
        return $this->belongsToMany(Chat::class, 'chat_profile');
    }

    public function messages(){
        return $this->hasMany(Message::class, 'chat_id');
    }

    public function messagesReverse(){
        return $this->hasMany(Message::class, 'chat_id')->orderByDesc('id');
    }

    public function getChatedId($myId)
    {
        $profile = Profile::whereId($myId)->first();
        foreach ($profile->chats as $chat){
            array_push($this->chatIdArray, $chat->profiles()->where('subscription.profile_id', '!=', auth()->id())
                ->pluck('profile_id')->first());
        }
        return $this->chatIdArray;
    }
}
