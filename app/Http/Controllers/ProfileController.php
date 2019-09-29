<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpdateProfile;
use App\Http\Requests\ValidateProfile;
use App\Profile;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    protected $profilesModel;

    public function __construct(Profile $model){
        $this->profilesModel = $model;
    }

    public function create(){
        return view('profiles.create');
    }

    public function store(ValidateProfile $request){
        $this->profilesModel->saveWithId($request->input(), Auth::id());
        return redirect('/preferences/create');
    }

    public function edit(){
        $profile = $this->profilesModel->getById(Auth::id());
        return view('profiles.edit', compact('profile'));
    }

    public function update(ValidateProfile $request){
        $this->profilesModel->updateWithId($request->input(), Auth::id());
    }

    public function get(){
        $profiles = $this->profilesModel->getChatProfiles(auth()->id());
        return response()->json($profiles);
    }
}
