<?php

namespace App;

use App\Pivots\Subscription;
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
            if ($likeId = $this->where('profile_id', $partner_id)->
            where('partner_id', $profile_id)->pluck('like_id')->toArray()) {
                $chat = Chat::create();
                Subscription::create(['chat_id' => $chat->id, 'profile_id' => $partner_id]);
                Subscription::create(['chat_id' => $chat->id, 'profile_id' => $profile_id]);
//                $chat->profiles()->attach($profile_id);
//                $chat->profiles()->attach($partner_id);
                $chat->messages()->create(['from' => $profile_id, 'to' => $partner_id, 'text' => 'init message']);
                $this->where('like_id', array_values($likeId))->delete();
            } else {
                $this->create(['profile_id' => $profile_id, 'partner_id' => $partner_id]);
            }
        }
    }

    public function getLikedId($profileId)
    {
        return $this->where('profile_id', $profileId)->get()->pluck('partner_id')->toArray();
    }
}
