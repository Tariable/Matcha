<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePreferences;
use App\Http\Requests\UpdatePreferences;
use App\Profile;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use App\Preference;
use Illuminate\Foundation\Validation\ValidatesRequests;
use App\Tag;
use Illuminate\Http\Request;

class PreferenceController extends Controller
{
    public function index()
    {
        $data = Preference::whereId(Auth::id())->first();
        return response()->json(array('pref' => $data));
    }


    public function create()
    {
        return view('preferences.create');
    }


    public function store(StorePreferences $request)
    {
        $data = $request->input();
        $data['id'] = Auth::id();
        Preference::create($data);
        return redirect("/recs");
    }


    public function edit()
    {
        $preference = Preference::whereId(Auth::id())->get()->first();
        return view('preferences.edit', compact('preference'));
    }


    public function update(UpdatePreferences $request)
    {
        $data = $request->input();
        $data['id'] = Auth::id();
        $preferences = Preference::whereId(Auth::id())->get()->first();
        $preferences->update($data);
    }

    public function rules()
    {
        return [
            'lowerAge' => 'required|numeric|min:18|max:97',
            'upperAge' => 'required|numeric|min:21|max:100',
            'distance' => 'required|numeric|min:3|max:100',
            'sex' => ['required',
                Rule::in(['female', 'male', '%ale']),]
        ];
    }

    public function ajaxRules()
    {
        return [
            'lowerAge' => 'required',
            'upperAge' => 'required',
            'distance' => 'required',
            'sex' => ['required',
                Rule::in(['female', 'male', '%ale']),]
        ];
    }

    public function errorMessages()
    {
        return [
            'lowerAge' => 'Lower age must be between 18 and 97',
            'upperAge' => 'Upper age must be between 21 and 100',
            'distance' => 'Distance must be less than 100 km',
            'sex.required' => 'Sex preferences field is required',
            'sex.in' => 'Sex preferences can be only male, female or bisexual',
        ];
    }

}
