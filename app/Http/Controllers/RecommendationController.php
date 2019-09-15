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

    public function getRecs()
    {
        $recommendations = $this->recsService->getRecommendations(Auth::id());
        return response()->json(array('recommendationsId' => $recommendations));
    }
}
