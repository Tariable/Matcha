<?php

namespace App\Http\Controllers;

use App\Preference;
use App\Ban;
use App\Profile;
use App\Like;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class RecommendationController extends Controller
{
    protected $profileModel;
    protected $preferencesModel;
    protected $likeModel;
    protected $banModel;

    public function __construct(Profile $profile, Preference $preferences, Like $like, Ban $ban){
        $this->profileModel = $profile;
        $this->preferencesModel = $preferences;
        $this->likeModel = $like;
        $this->banModel = $ban;
    }

    public function show()
    {
        $pref = $this->preferencesModel->getById(Auth::id());
        return view('recommendations.show', compact('pref'));
    }

    public function getData($id)
    {
        $profile = $this->profileModel->getById($id);
        $user = Profile::where('id', '=', Auth::id())->first();
        $data['id'] = $profile->id;
        $data['name'] = $profile->name;
        $data['age'] = $this->countAge($profile->date_of_birth);
        $data['desc'] = $profile->description;
        $data['rating'] = $profile->rating;
        $data['distance'] = $this->getDistance($user->latitude, $user->longitude,
            $profile->latitude, $profile->longitude);
        return response()->json(array('profileData' => $data));
    }

    public function getRecs()
    {
        $age = $this->profileModel->getAge(Auth::id());
        $pref = $this->preferencesModel->getById(Auth::id());
        $profile = $this->profileModel->getById(Auth::id());
        $banned_id = $this->banModel->getBannedId(Auth::id());
        $liked_id = $this->likeModel->getLikedId(Auth::id());
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

    public function countAge($date)
    {
        return Carbon::createFromFormat('Y-m-d', $date)->diffInYears(Carbon::now(), false);
    }

    public function ageGap($pref)
    {
        $from = Carbon::now()->subYear($pref->upperAge);
        $to = Carbon::now()->subYear($pref->lowerAge);
        return array($from, $to);
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
