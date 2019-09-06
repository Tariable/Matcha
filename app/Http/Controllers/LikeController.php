<?php

namespace App\Http\Controllers;

use App\Like;
use App\Profile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LikeController extends Controller
{
    public function like($partner_id)
    {
        if (isset(Profile::where('id', $partner_id)->first()->id)) {
            Like::create(['profile_id' => Auth::id(), 'partner_id' => $partner_id]);
        } else {
            return redirect('/');
        }
    }

    public function getLikes()
    {
        return Like::where('partner_id', Auth::id());
    }
}
