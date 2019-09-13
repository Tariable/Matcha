<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePhoto;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Photo;
use Intervention\Image\Facades\Image;

class PhotoController extends Controller
{
    protected $photosModel;
    protected $photoLimit;

    public function __construct(Photo $model){
        $this->photosModel = $model;
        $this->photoLimit = 5;
    }

    public function show($userId)
    {
        return response()->json($this->photosModel->getProfilePhotos($userId));
    }


    public function store(StorePhoto $request)
    {
        if ($this->photosModel->getPhotoNumberOfProfile(Auth::id()) < $this->photoLimit)
            $this->photosModel->savePhoto($request->file('photo'), Auth::id());
        else
            abort('422');
    }


    public function destroy($photoId)
    {
        $this->photosModel->destroyPhoto($photoId);
    }

    public function getLastPhoto($userId)
    {
        return response()->json($this->photosModel->getProfileLastPhoto($userId));
    }
}
