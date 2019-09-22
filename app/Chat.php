<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Chat extends Model
{
    protected $guarded = [];

    public function getChatId($profileId)
    {
        $numberOfProfileChats = $this->where('profile_id', $profileId)->pluck('partner_id')->toArray();
        $numberOfPartnerChats = $this->where('partner_id', $profileId)->pluck('profile_id')->toArray();
        return array_merge($numberOfPartnerChats, $numberOfProfileChats);
    }
}
