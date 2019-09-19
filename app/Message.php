<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    protected $guarded = [];

    public function getProfileMessages($id){
        return $this->where('from', $id)->orWhere('to', $id)->get();
    }

    public function getAllChats(){
        return $this->take(10)->get();
    }
}
