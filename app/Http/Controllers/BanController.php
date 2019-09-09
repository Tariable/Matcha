<?php

namespace App\Http\Controllers;

use App\Ban;
use App\Profile;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class BanController extends Controller
{
    public function ban($banned_id)
    {
        if (Profile::where('id', $banned_id)->exists())
            Ban::create(['profile_id' => Auth::id(), 'banned_id' => $banned_id]);
    }
}
