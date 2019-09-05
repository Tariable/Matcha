<?php

namespace App\Http\Controllers;

use App\Preference;
use App\Tag;
use App\Profile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Scope;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class RecommendationController extends Controller
{
    public function getData()
    {
        $id = 3;
        $profile = Profile::where('id', '=', $id)->first();
        $user = Profile::where('id', '=', Auth::id())->first();
        $data['name'] = $profile->name;
        $data['age'] = $this->countAge($profile->date_of_birth);
        $data['desc'] = $profile->description;
        $data['rating'] = $profile->rating;
        $data['distance'] = $this->getDistance($user->latitude, $user->longitude,
            $profile->latitude, $profile->longitude);
        $data['common_tags'] = $this->getCommonTags($id);
        return $data;
    }

    public function getRecs()
    {
        $age = $this->getAge();
        $pref = $this->getPreferences();
        $profile = $this->getProfile();
        return Profile::join('preferences', 'profiles.id', '=', 'preferences.id')->
        where(function ($query) use ($profile) {
            $query->where('pref_sex', '=', $profile->gender)->
            orWhere('pref_sex', '=', '%ale');
        })->
        where('gender', 'like', $pref->pref_sex)->
        whereBetween('date_of_birth', $this->ageGap($pref))->
        where('lowerAge', '<=', $age)->
        where('upperAge', '>=', $age)->
        inRange($profile->longitude, $profile->latitude)->
        closeTo($profile->longitude, $profile->latitude, $pref->distance)->
        whereNotIn('profiles.id', [$pref->id])->get()->pluck('id');
    }

    public function getCommonTags($id)
    {
        $profileTags = unserialize(Preference::where('id', '=', $id)->get()->pluck('tags')[0]);
        $userTags = unserialize(Preference::where('id', '=', Auth::id())->get()->pluck('tags')[0]);
        $common = array_intersect($userTags, $profileTags);
        return Tag::whereIn('id', $common)->pluck('name');
    }

    public function countAge($date)
    {
        return Carbon::createFromFormat('Y-m-d', $date)->diffInYears(Carbon::now(), false);
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

    public function getDistance($lat1, $lon1, $lat2, $lon2)
    {
        if (($lat1 == $lat2) && ($lon1 == $lon2)) {
            return 0;
        } else {
            $theta = $lon1 - $lon2;
            $dist = sin(deg2rad($lat1)) * sin(deg2rad($lat2)) + cos(deg2rad($lat1)) * cos(deg2rad($lat2)) * cos(deg2rad($theta));
            $dist = acos($dist);
            $dist = rad2deg($dist);
            $km = $dist * 60 * 1.1515 * 1.609344;
            return (intval($km));
        }
    }
}
