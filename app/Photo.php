<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;

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





    public function savePhoto($photo, $userId){
        $photoName = $this->createName($photo);
        $photo->storeAs('public/photos', $photoName);
        $this->fitImage($photoName)->save();
        $this->create(['user_id' => $userId, 'path' => '/storage/photos/' . $photoName]);
    }

    public function fitImage($photoName){
        return Image::make(public_path("/storage/photos/{$photoName}"))->fit(480, 640);
    }

    public function createName($photo){
        $photoExtension = $photo->getClientOriginalExtension();
        return bin2hex(random_bytes(10)) . '.' . $photoExtension;
    }

    public function getPhotoNumberOfProfile($userId)
    {
        return $this->where('user_id', $userId)->count();
    }





    public function destroyPhoto($imageId){
        $this->removeFromStorage($this->getPhotoPath($imageId));
        $this->where('id', $imageId)->delete();
    }

    public function getPhotoPath($imageId){
        return $this->where('id', $imageId)->pluck('path')->first();
    }

    public function removeFromStorage($path){
        Storage::delete($this->modifyPathToStorage($path));
    }

    public function modifyPathToStorage($path){
        return str_replace('storage', 'public', $path);
    }
}
