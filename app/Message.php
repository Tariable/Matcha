<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    protected $guarded = [];

    public function saveMessage($data, $fromId){
        $data['from'] = $fromId;
        return $this->create($data);
    }

    public function getProfileMessages($myId, $partnerId){
        $messages = $this->where(function ($q) use ($myId, $partnerId){
            $q->where('from', $myId);
            $q->where('to', $partnerId);
        })->orWhere(function($q) use ($myId, $partnerId){
            $q->where('from', $partnerId);
            $q->where('to', $myId);
        })->get();

        return $messages;
    }

    public function getAllChats(){
        return $this->take(10)->get();
    }
}
