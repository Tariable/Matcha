<?php

namespace App\Http\Controllers;

use App\Preference;
use App\Profile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Scope;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class RecommendationController extends Controller
{
    public function getRecs()
    {
//        dd(\DB::select(\DB::raw('
//    select ST_Distance_Sphere(
//        point(:lonA, :latA),
//        point(:lonB, :latB)
//    ) / 1000 < 14
//'), [
//            'lonA' => 37.43225,
//            'latA' => 55.69692,
//            'lonB' => 37.62251,
//            'latB' => 55.75322,
//        ]));

        $pref = $this->getPreferences();
        $location = $this->getLocation();
        $recs = Profile:://whereBetween('date_of_birth', $this->ageGap($pref))->
            closeTo($location->current_longitude, $location->current_latitude)->
            //whereNotIn('id', [$pref->id])
        get()->dd();
    }

    public function getPreferences()
    {
        return Preference::where('id', Auth::id())->get()->first();
    }

    public function getLocation()
    {
        return Profile::where('id', Auth::id())->select('current_longitude', 'current_latitude')->get()->first();
    }

    public function ageGap($pref)
    {
        $from = Carbon::now()->subYear($pref->upperAge);
        $to = Carbon::now()->subYear($pref->lowerAge);
        return array($from, $to);
    }

}
