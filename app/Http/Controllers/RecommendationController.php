<?php

namespace App\Http\Controllers;

use App\Preference;
use App\Tag;
use App\Ban;
use App\Profile;
use App\Like;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Scope;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class RecommendationController extends Controller
{
    public function show()
    {
        $pref = $this->getPreferences();
        $data['lowerAge'] = $pref->lowerAge;
        $data['upperAge'] = $pref->upperAge;
        $data['distance'] = $pref->distance;
        return view('recommendations.show', compact('data'));
    }

    public function getData($id)
    {
        $profile = Profile::where('id', '=', $id)->first();
        $user = Profile::where('id', '=', Auth::id())->first();
        $data['id'] = $profile->id;
        $data['name'] = $profile->name;
        $data['age'] = $this->countAge($profile->date_of_birth);
        $data['desc'] = $profile->description;
        $data['rating'] = $profile->rating;
        $data['distance'] = $this->getDistance($user->latitude, $user->longitude,
            $profile->latitude, $profile->longitude);
        $data['common_tags'] = $this->getCommonTags($id);
        return response()->json(array('profileData' => $data));
    }

    public function getRecs()
    {
        $age = $this->getAge();
        $pref = $this->getPreferences();
        $profile = $this->getProfile();
        $banned_id = $this->getBanned();
        $liked_id = $this->getLiked();
        $recommendations = Profile::join('preferences', 'profiles.id', '=', 'preferences.id')->
        where(function ($query) use ($profile) {
            $query->where('sex', '=', $profile->gender)->
            orWhere('sex', '=', '%ale');
        })->
        where('gender', 'like', $pref->sex)->
        whereBetween('date_of_birth', $this->ageGap($pref))->
        where('lowerAge', '<=', $age)->
        where('upperAge', '>=', $age)->
        inRange($profile->longitude, $profile->latitude)->
        closeTo($profile->longitude, $profile->latitude, $pref->distance)->
        whereNotIn('profiles.id', $banned_id)->
        whereNotIn('profiles.id', $liked_id)->
        whereNotIn('profiles.id', [$pref->id])->get()->pluck('id');
        return response()->json(array('recommendationsId' => $recommendations));
    }

    public function getCommonTags($id)
    {
        $serializedProfileTags = Preference::where('id', '=', $id)->get()->pluck('tags')[0];
        $profileTags = ($serializedProfileTags == '0') ? [0] : unserialize($serializedProfileTags);
        $serializedUserTags = Preference::where('id', '=', Auth::id())->get()->pluck('tags')[0];
        $userTags = ($serializedUserTags == '0') ? [0] : unserialize($serializedUserTags);
        $common = array_intersect($userTags, $profileTags);
        return Tag::whereIn('id', $common)->pluck('name');
    }

    public function getLiked()
    {
        return Like::where('profile_id', '=', Auth::id())->get()->pluck('partner_id');
    }

    public function getBanned()
    {
        return Ban::where('profile_id', '=', Auth::id())->get()->pluck('banned_id');
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
