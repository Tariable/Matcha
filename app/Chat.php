<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Chat extends Model
{
    protected $guarded = [];

    public function profiles(){
        return $this->belongsToMany(Profile::class, 'chat_profile');
    }

    public function chats(){
        return $this->belongsToMany(Chat::class, 'chat_profile');
    }

    public function messages(){
        return $this->hasMany(Message::class, 'chat_id');
    }

    public function getProfileChats($myId){
        $chats = $this->where('profile_id', $myId)->orWhere('partner_id', $myId)->get();
        foreach ($chats as $chat){
            $chat->messages;
            $chat->profile;
        }
        return $chats;
    }

    public function getChatId($myId)
    {
        $profile = Profile::whereId('2001')->first();
        foreach ($profile->chats as $chat){
            array_push($array, $chat->pivot->profile_id);
        }
        dd($array);
//        dd($chats->profiles()->pluck('profiles.id'));
        return $chats;
    }
}
