<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Photo extends Model
{
    protected $guarded = [];

    public function profile(){
        return $this->belongsTo(Profile::class, 'user_id');
    }

    public function getProfilePhotos($userId){
        return $this->where('user_id', $userId)->get();
    }

    public function getProfileLastPhoto($userId){
        return $this->where('user_id', $userId)->orderBy('id', 'desc')->first();
    }

    public function getPhotoNumberOfProfile($userId)
    {
        return $this->where('user_id', $userId)->count();
    }

    public function getPhotoPath($imageId){
        return $this->where('id', $imageId)->pluck('path')->first();
    }
}
