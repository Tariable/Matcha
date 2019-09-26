<?php


namespace App\Services;

use App\Like;
use App\Ban;
use App\Profile;
use App\Chat;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class RecommendationService
{
    protected   $profileModel;
    protected   $likeModel;
    protected   $banModel;
    protected   $chatModel;

    public function __construct(Profile $profileModel, Like $likeModel, Ban $banModel, Chat $chatModel){
        $this->profileModel = $profileModel;
        $this->likeModel = $likeModel;
        $this->banModel = $banModel;
        $this->chatModel = $chatModel;
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
        $data['distance'] = $this->getDistance($partnerProfile->latitude, $partnerProfile->longitude,
            $myProfile->latitude, $myProfile->longitude);
        return $data;
    }

    public function getRecommendations($myId)
    {
        $profile = $this->profileModel->getById($myId);
        $age = $profile->getAge($myId);
        $pref = $profile->preference;
        $banned_id = $this->banModel->getBannedId(Auth::id());
        $liked_id = $this->likeModel->getLikedId(Auth::id());
        $chat_id = $this->chatModel->getChatId(Auth::id());

        $usersWhoLiked = $this->likeModel->where('partner_id', '=', $myId)->pluck('profile_id')->toArray();

        $recommendations = $this->profileModel->
        join('preferences', 'profiles.id', '=', 'preferences.id')->
        where(function ($query) use ($profile) {
            $query->where('sex', '=', $profile->gender)->
            orWhere('sex', '=', '%ale');
        })->
        where('gender', 'like', $pref->sex)->
        where('lowerAge', '<=', $age)->
        where('upperAge', '>=', $age)->
        whereNotIn('profiles.id', $banned_id)->
        whereNotIn('profiles.id', $liked_id)->
        whereNotIn('profiles.id', $chat_id)->
        whereNotIn('profiles.id', [$pref->id])->
        whereBetween('date_of_birth', $this->ageGap($pref))->
        inRange($profile->longitude, $profile->latitude)->
        closeTo($profile->longitude, $profile->latitude, $pref->distance)->
        get()->pluck('id');
        if ($recommendations->count() !== 0) {
            $recommendations = $this->filterByDistance($recommendations);
        }
        $recommendations = $this->mixLikedUsers($recommendations, $usersWhoLiked);
        return $recommendations;
    }

    public function mixLikedUsers($recommendations, $usersWhoLiked)
    {
        foreach ($usersWhoLiked as $user) {
            array_splice($recommendations, random_int(2, 10), 0, $user);
        }
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

    public function filterByDistance($recommendations)
    {
        $user = Profile::where('id', '=', Auth::id())->first();
        $filtered = Profile::join('preferences', 'profiles.id', '=', 'preferences.id')->
        whereIn('profiles.id', $recommendations)->get(['latitude', 'longitude', 'profiles.id']);
        foreach ($filtered as $profile) {
            $distances[$profile->id] = $this->getDistance($profile->latitude, $profile->longitude, $user->latitude, $user->longitude);
        }
        asort($distances);
        return array_keys($distances);
    }
}
