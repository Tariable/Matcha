<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Like extends Model
{
    protected $guarded = [];

    public function saveIfExist($profile_id, $like_id){
        if (Profile::whereId($like_id)->exists())
            $this->create(['profile_id' => $profile_id, 'banned_id' => $like_id]);
    }
}
