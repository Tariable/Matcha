<?php

namespace App\Http\Controllers;

use App\Ban;
use App\Profile;
use Illuminate\Support\Facades\Auth;

class BanController extends Controller
{
    protected $banModel;

    public function __construct(Ban $model){
        $this->banModel = $model;
    }

    public function store($banned_id)
    {
        $this->banModel->saveIfExist(Auth::id(), $banned_id);
    }
}
