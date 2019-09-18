<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class Profile extends Model
{
    protected $guarded = [];

    public function user()
    {
        return $this->belongsTo(User::class, 'id');
    }

    public function photo()
    {
        return $this->hasMany(Photo::class, 'user_id');
    }

    public function preference()
    {
        return $this->hasOne(Preference::class, 'id');
    }

    public function like()
    {
        return $this->hasMany(Like::class, 'profile_id');
    }

    public function ban()
    {
        return $this->hasMany(Ban::class, 'profile_id');
    }

    public function getAll(){
        return $this->All();
    }

    public function getAge($profileId){
        $date = $this->whereId($profileId)->pluck('date_of_birth')->first();
        return Carbon::createFromFormat('Y-m-d', $date)->diffInYears(Carbon::now(), false);
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
