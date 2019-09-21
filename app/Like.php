<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Like extends Model
{
    protected $guarded = [];

    public function profile()
    {
        return $this->belongsTo(Profile::class, 'user_id');
    }

    public function saveIfExist($profile_id, $partner_id)
    {
        if (Profile::where('id', $partner_id)->exists()) {
//            if (Like::where('profile_id', '=', $partner_id)->where('partner_id', '=', $partner_id)) {
//                dd('here');
//            }
            $this->create(['profile_id' => $profile_id, 'partner_id' => $partner_id]);
        }
    }

    public function getLikedId($profileId)
    {
        return $this->where('profile_id', $profileId)->get()->pluck('partner_id')->toArray();
    }
}
