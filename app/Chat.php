<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Chat extends Model
{
    protected $guarded = [];

    public function profile(){
        return $this->belongsToMany(Profile::class);
    }

    public function messages(){
        return $this->hasMany(Message::class);
    }

    public function getProfileChats($myId){
        return $this->where('profile_id', $myId)->orWhere('partner_id', $myId)->get();
    }

    public function getChatId($profileId)
    {
        $numberOfProfileChats = $this->where('profile_id', $profileId)->pluck('partner_id')->toArray();
        $numberOfPartnerChats = $this->where('partner_id', $profileId)->pluck('profile_id')->toArray();
        return array_merge($numberOfPartnerChats, $numberOfProfileChats);
    }
}
