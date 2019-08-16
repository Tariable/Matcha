<?php

namespace App\Http\Controllers;

use App\Profile;
use Illuminate\Http\Request;

class ProfileController extends Controller
{
    public function store()
    {
        $data = request()->validate([
            'name' => 'required|min:2|max:60',
            'date_of_birth' => 'required',
            'description' => 'required',
            'gender' => 'required',
            'current_latitude' => 'required',
            'current_longitude' => 'required',
        ]);

        Profile::create($data);
    }
}
