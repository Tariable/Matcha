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


    //--------------------------------------scope section--------------------------------------//


    public function scopeCloseTo(Builder $query, $longitude, $latitude, $range)
    {
        return $query->whereRaw("
       ST_Distance_Sphere(
            point(longitude, latitude),
            point(?, ?)
        ) / 1000 < ?
    ", [
            $longitude,
            $latitude,
            $range,
        ]);
    }

    public function scopeInRange(Builder $query, $longitude, $latitude)
    {
        return $query->whereRaw("
       ST_Distance_Sphere(
            point(longitude, latitude),
            point(?, ?)
        ) / 1000 < distance
    ", [
            $longitude,
            $latitude,
        ]);
    }

}
