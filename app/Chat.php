<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Chat extends Model
{
    protected $guarded = [];

    public function profile(){
        return $this->belongsTo(Profile::class, 'partner_id');
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

    public function getChatId($profileId)
    {
        $numberOfProfileChats = $this->where('profile_id', $profileId)->pluck('partner_id')->toArray();
        $numberOfPartnerChats = $this->where('partner_id', $profileId)->pluck('profile_id')->toArray();
        return array_merge($numberOfPartnerChats, $numberOfProfileChats);
    }
}
