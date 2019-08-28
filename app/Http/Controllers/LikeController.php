<?php

namespace App\Http\Controllers;

use App\Like;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LikeController extends Controller
{
    public function like($partner_id)
    {
       Like::create(['profile_id' => Auth::id(), 'partner_id' => $partner_id]);
    }

    public function getWhoLikedThisProfile()
    {
        return Like::where('partner_id', Auth::id());
    }
}
