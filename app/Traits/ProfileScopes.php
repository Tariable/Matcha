<?php


namespace App\Traits;


use Illuminate\Database\Eloquent\Builder;

trait ProfileScopes
{
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