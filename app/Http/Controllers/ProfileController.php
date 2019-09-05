<?php

namespace App\Http\Controllers;

use App\Profile;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    public function create()
    {
        return view('profiles.create');
    }

    public function store()
    {
        $data = request()->validate($this->rules(), $this->error_messages());
        $data['id'] = Auth::id();
        Profile::create($data);

        return redirect('/preferences/create');
    }

    public function edit()
    {
        $profile = Profile::whereId(Auth::id())->get()->first();
        return view('profiles.edit', compact('profile'));
    }

    public function update(Request $request)
    {
//        dd($request->all());
        $data = request()->validate($this->rules(), $this->error_messages());
        $profile = Profile::where('id', Auth::id())->get()->first();
        $profile->update($data);
    }

    public function rules()
    {
        return [
            'name' => 'required|alpha|min:2|max:20',
            'date_of_birth' => 'required|date_format:"Y-m-d"|after:-100 years|before:-18 years',
            'description' => 'required',
            'gender' => 'required|in:male,female',
            'notification' => 'required|in:1,0',
            'current_latitude' => 'required|numeric|max:180|min:-180',
            'current_longitude' => 'required|numeric|max:90|min:-90',
        ];
    }

    public function error_messages()
    {
        return [
            'date_of_birth.after' => 'Your age must be less than 100 years old',
            'date_of_birth.before' => 'Your age must be over 18',
        ];
    }
}
