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
            'current_latitude' => 'required|numeric|max:180|min:-180',
            'current_longitude' => 'required|numeric|max:90|min:-90',
        ]);

        dd($data);


        Profile::create($data);
    }
}
