<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Like extends Model
{
    protected $guarded = [];

    public function saveIfExist($profile_id, $like_id){
        if (Profile::whereId($like_id)->exists())
            $this->create(['profile_id' => $profile_id, 'partner_id' => $like_id]);
    }

    public function getLikedId($profileId){
        return $this->where('profile_id', $profileId)->get()->pluck('partner_id');
    }
}
