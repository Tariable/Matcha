<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpdateProfile;
use App\Http\Requests\StoreProfile;
use App\Profile;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    public function create()
    {
        return view('profiles.create');
    }

    public function store(StoreProfile $request)
    {
        $data = $request->input();
        $data['id'] = Auth::id();
        Profile::create($data);
        return redirect('/preferences/create');
    }

    public function edit()
    {
        $profile = Profile::whereId(Auth::id())->get()->first();
        return view('profiles.edit', compact('profile'));
    }

    public function update(UpdateProfile $request)
    {
        $data = $request->input();
        $profile = Profile::where('id', Auth::id())->get()->first();
        $profile->update($data);
    }
}
