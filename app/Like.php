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

    public function getLikedId($profileId)
    {
        return $this->where('profile_id', $profileId)->get()->pluck('partner_id')->toArray();
    }
}
