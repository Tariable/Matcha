<?php

namespace App\Services;

use App\Photo;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Storage;

class PhotoService
{
    protected $photosModel;

    public function __construct(Photo $model)
    {
        $this->photosModel = $model;
    }

    public function savePhoto($photo, $userId)
    {
        $photoName = $this->createName($photo);
        $photo->storeAs('public/photos', $photoName);
        $this->fitImage($photoName)->save();
        $this->photosModel->create(['user_id' => $userId, 'path' => '/storage/photos/' . $photoName]);
    }

    public function fitImage($photoName)
    {
        return Image::make(public_path("/storage/photos/{$photoName}"))->fit(480, 640);
    }

    public function createName($photo)
    {
        $photoExtension = $photo->getClientOriginalExtension();
        return bin2hex(random_bytes(10)) . '.' . $photoExtension;
    }

    public function destroyPhoto($imageId)
    {
        $this->removeFromStorage($this->photosModel->getPhotoPath($imageId));
        $this->photosModel->where('id', $imageId)->delete();
    }

    public function removeFromStorage($path)
    {
        Storage::delete($this->modifyPathToStorage($path));
    }

    public function modifyPathToStorage($path)
    {
        return str_replace('storage', 'public', $path);
    }
}