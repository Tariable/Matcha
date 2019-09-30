<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePhoto;
use Illuminate\Support\Facades\Auth;
use App\Photo;
use App\Services\PhotoService;

class PhotoController extends Controller
{
    protected $photoModel;
    protected $photoLimit;
    protected $photoService;

    public function __construct(Photo $model, PhotoService $photoService)
    {
        $this->photoModel = $model;
        $this->photoLimit = 5;
        $this->photoService = $photoService;
    }

    public function show($userId)
    {
        return response()->json($this->photoModel->getProfilePhotos($userId));
    }

    public function store(StorePhoto $request)
    {
        if ($this->photoModel->getPhotoNumberOfProfile(Auth::id()) < $this->photoLimit)
            $this->photoService->savePhoto($request->file('photos'), Auth::id());
    }

    public function destroy($photoId)
    {
        $this->photoService->destroyPhoto($photoId);
    }

    public function getLastPhoto($userId)
    {
        return response()->json($this->photoModel->getProfileLastPhoto($userId));
    }
}
