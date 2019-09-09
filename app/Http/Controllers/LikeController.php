<?php

namespace App\Http\Controllers;

use App\Like;
use App\Profile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LikeController extends Controller
{
    public function like($partnerId)
    {
        if (Profile::where('id', $partnerId)->exists())
            Like::create(['profile_id' => Auth::id(), 'partner_id' => $partnerId]);
    }

    public function getLikes()
    {
        return Like::where('partner_id', Auth::id());
    }
}
