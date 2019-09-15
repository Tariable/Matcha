<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Ban extends Model
{
    protected $guarded = [];

    public function profile(){
        return $this->belongsTo(Profile::class, 'user_id');
    }


    public function saveIfExist($profile_id, $banned_id){
        if (Profile::where('id', $banned_id)->exists())
            $this->create(['profile_id' => $profile_id, 'banned_id' => $banned_id]);
    }

    public function getBannedId($profileId){
        return $this->where('profile_id', '=', $profileId)->get()->pluck('banned_id');
    }
}
