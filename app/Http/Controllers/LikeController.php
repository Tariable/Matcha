<?php

namespace App\Http\Controllers;

use App\Like;
use App\Profile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LikeController extends Controller
{
    protected $likeModel;

    public function __construct(Like $model){
        $this->likeModel = $model;
    }

    public function store($partnerId)
    {
        $this->likeModel->saveIfExist(Auth::id(), $partnerId);
    }
}
