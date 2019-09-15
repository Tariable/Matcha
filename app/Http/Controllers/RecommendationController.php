<?php

namespace App\Http\Controllers;

use App\Services\RecommendationService;
use Illuminate\Support\Facades\Auth;

class RecommendationController extends Controller
{
    protected $recsService;

    public function __construct(RecommendationService $recsService){
        $this->recsService = $recsService;
    }

    public function show()
    {
        $pref = $this->recsService->getPreferences(Auth::id());
        return view('recommendations.show', compact('pref'));
    }

    public function getProfile($id)
    {
        $data = $this->recsService->getProfileData($id, Auth::id());
        return response()->json(array('profileData' => $data));
    }

    public function getRecs($filter = 0)
    {
        $recommendations = $this->recsService->getRecommendations(Auth::id());
        return response()->json(array('recommendationsId' => $recommendations));
    }

    public function applyFilters($filter, $recommendations)
    {
        return ($filter == 'distance') ? $this->filterByDistance($recommendations)
            : $this->filterByAge($recommendations);
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

    public function filterByAge($recommendations)
    {
        $filtered = Profile::join('preferences', 'profiles.id', '=', 'preferences.id')->
        whereIn('profiles.id', $recommendations)->get(['date_of_birth', 'profiles.id']);
        foreach ($filtered as $profile) {
            $ages[$profile->id] = $this->countAge($profile->date_of_birth);
        }
        asort($ages);
        return array_keys($ages);
    }
}
