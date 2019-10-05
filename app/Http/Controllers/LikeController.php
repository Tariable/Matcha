<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use App\Services\LikeService;
use App\Like;

class LikeController extends Controller
{
    protected $likeService;
    protected $likeModel;

    public function __construct(LikeService $service, Like $model){
        $this->likeService = $service;
        $this->likeModel = $model;
    }

    public function store($partnerId)
    {
        return response()->json($this->likeService->saveIfExist(Auth::id(), $partnerId));
    }

    public function getWhoLikedMe()
    {
        return response()->json($this->likeModel->getWhoLikedMe(Auth::id()));
    }
}
