<?php

namespace App\Http\Controllers;

use App\Profile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProfilesController extends Controller
{
    public function create()
    {
        return view('profiles.create');
    }

    public function store()
    {
        $data = request()->validate($this->rules(), $this->error_messages());

        $data['user_id'] = Auth::id();

        $profile = Profile::create($data);
    }

    public function update(Profile $profile)
    {
        $data = request()->validate($this->rules(), $this->error_messages());

        $profile->update($data);

        return redirect('/home');
    }

    public function rules()
    {
        return [
            'name' => 'required|alpha|min:2|max:60',
            'date_of_birth' => 'required|date_format:"Y-m-d"|after:-100 years|before:-18 years',
            'description' => 'required',
            'gender' => 'required|in:Male,Female',
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
