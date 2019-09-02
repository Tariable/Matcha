<?php

namespace App;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class Profile extends Model
{
    protected $guarded = [];

    public function user()
    {
        return $this->belongsTo(User::class, 'id');
    }

    public function preference()
    {
        return $this->hasOne(Preference::class, 'id');
    }


    public function scopeCloseTo(Builder $query, $longitude, $latitude)
    {
        return $query->whereRaw("
       ST_Distance_Sphere(
            point(current_longitude, current_latitude),
            point(?, ?)
        ) * .0001 = 0
    ", [
            $longitude,
            $latitude,
        ]);
    }
}
