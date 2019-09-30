<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpdateProfile;
use App\Http\Requests\StoreProfile;
use App\Profile;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    protected   $profilesModel;
    public      $chats = [];

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

    public function chatNames(){
        $myProfile = $this->profilesModel->getById(auth()->id());
        foreach ($myProfile->chats as $chat){
            $profile = $chat->profiles->where('id', '!=', auth()->id())->first();
            $unreadMessageCounter = $chat->messages->where('read','==','0')->count();
            $profile->unread = $unreadMessageCounter;
            $profile->lastMessage = $chat->messages->last();
            array_push($this->chats, $profile);
        }
        return response()->json($this->chats);
    }
}
