<?php

namespace App\Http\Controllers;

use App\Chat;
use App\Http\Requests\UpdateProfile;
use App\Http\Requests\StoreProfile;
use App\Message;
use App\Profile;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ProfileController extends Controller
{
    protected   $profilesModel;

    public function __construct(Profile $model){
        $this->profilesModel = $model;
    }

    public function create(){
        return view('profiles.create');
    }

    public function store(StoreProfile $request){
        $this->profilesModel->saveWithId($request->input(), auth()->id());
        return redirect('/preferences/create');
    }

    public function edit(){
        $profile = $this->profilesModel->getById(auth()->id());
        return view('profiles.edit', compact('profile'));
    }

    public function update(UpdateProfile $request){
        $this->profilesModel->updateWithId($request->input(), auth()->id());
    }

    public function get(){
        $profiles = $this->profilesModel->getChatProfiles(auth()->id());
        return response()->json($profiles);
    }
}
