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
        $age = $this->getAge();
        $pref = $this->getPreferences();
        $profile = $this->getProfile();
        $recs = Profile::join('preferences', 'profiles.id', '=', 'preferences.id')->
        where(function ($query) use ($profile) {
            $query->where('pref_sex', '=', $profile->gender)->
            orWhere('pref_sex', '=', '%ale');
        })->
        where('gender', 'like', $pref->pref_sex)->
        whereBetween('date_of_birth', $this->ageGap($pref))->
        where('lowerAge', '<=', $age)->
        where('upperAge', '>=', $age)->
        inRange($profile->current_longitude, $profile->current_latitude)->
        closeTo($profile->current_longitude, $profile->current_latitude, $pref->distance)->
        whereNotIn('profiles.id', [$pref->id])->get()->dd();
    }

    public function getPreferences()
    {
        return Preference::where('id', Auth::id())->get()->first();
    }

    public function getProfile()
    {
        return Profile::where('id', Auth::id())->get()->first();
    }

    public function ageGap($pref)
    {
        $from = Carbon::now()->subYear($pref->upperAge);
        $to = Carbon::now()->subYear($pref->lowerAge);
        return array($from, $to);
    }

    public function getAge()
    {
        $date = Profile::where('id', Auth::id())->pluck('date_of_birth')->first();
        return Carbon::createFromFormat('Y-m-d', $date)->diffInYears(Carbon::now(), false);
    }
}
