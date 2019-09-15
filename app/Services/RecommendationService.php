<?php


namespace App\Services;

use App\Profile;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class RecommendationService
{
    protected   $profileModel;

    public function __construct(Profile $profileModel){
        $this->profileModel = $profileModel;
    }

    public function getPreferences($profileId){
        return $this->profileModel->getById($profileId)->preference;
    }

    public function getProfileData($myId, $partnerId){
        $myProfile = $this->profileModel->getById($myId);
        $partnerProfile = $this->profileModel->getById($partnerId);
        $data['id'] = $myProfile->id;
        $data['name'] = $myProfile->name;
        $data['age'] = $this->countAge($myProfile->date_of_birth);
        $data['desc'] = $myProfile->description;
        $data['rating'] = $myProfile->rating;
        $data['distance'] = $this->getDistance($partnerProfile->latitude, $partnerProfile->longitude,
            $myProfile->latitude, $myProfile->longitude);
        return $data;
    }


    public function getRecommendations($myId)
    {
        $profile = $this->profileModel->getById($myId);
        $age = $profile->getAge($myId);
        $pref = $profile->preference;
        $banned_id = $profile->ban;
        $liked_id = $profile->like;

        $recommendations = $this->profileModel->join('preferences', 'profiles.id', '=', 'preferences.id')->
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

        return $recommendations;
    }


    public function getDistance($lat1, $lon1, $lat2, $lon2){
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

    public function countAge($date){
        return Carbon::createFromFormat('Y-m-d', $date)->diffInYears(Carbon::now(), false);
    }

    public function ageGap($pref){
        $from = Carbon::now()->subYear($pref->upperAge);
        $to = Carbon::now()->subYear($pref->lowerAge);
        return array($from, $to);
    }


}
