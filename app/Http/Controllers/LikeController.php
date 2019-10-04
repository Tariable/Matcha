<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use App\Services\LikeService;

class LikeController extends Controller
{
    protected $likeService;

    public function __construct(LikeService $model){
        $this->likeService = $model;
    }

    public function store($partnerId)
    {
        return response()->json($this->likeService->saveIfExist(Auth::id(), $partnerId));
    }
}
