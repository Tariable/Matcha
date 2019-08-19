<?php

namespace App\Http\Controllers;

use App\Profile;
use Illuminate\Http\Request;

class ProfilesController extends Controller
{
    public function create()
    {
        return view('profiles.create');
    }

    public function store()
    {
        $data = request()->validate([
            'name' => 'required|min:2|max:60',
            'date_of_birth' => 'required|date_format:"Y-m-d"',
            'description' => 'required',
            'gender' => 'required|in:Male,Female',
            'current_latitude' => 'required',
            'current_longitude' => 'required',
        ]);


        Profile::create($data);
    }
}
