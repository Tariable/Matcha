<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use App\Preference;
use Illuminate\Foundation\Validation\ValidatesRequests;
use App\Tag;
use Illuminate\Http\Request;

class PreferenceController extends Controller
{

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $tags = Tag::all()->pluck('name');

        return view('preference.create', compact('tags'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = $this->validate($request, $this->rules(), $this->errorMessages());

        $this->savePreferences($data);

        return redirect("/");
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    public function savePreferences($data)
    {
        $data['profile_id'] = Auth::id();
        $data['tags'] = (isset($data['tags'])) ? serialize($data['tags']) : 0;
        Preference::create($data);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function rules()
    {

        return [
            'lowerAge' => 'required|numeric|min:18|max:97',
            'upperAge' => 'required|numeric|min:21|max:100',
            'distance' => 'required|numeric|min:3|max:100',
            'pref_sex' => ['required',
                            Rule::in(['bi', 'male', 'female']),],
            'tags' => 'sometimes|array',
            'tags.*' => 'numeric|min:1|max:' . Tag::all()->count()
        ];
    }

    public function errorMessages()
    {
        return [
            'lowerAge' => 'Lower age must be between 18 and 97',
            'upperAge' => 'Upper age must be between 21 and 100',
            'distance' => 'Distance must be less than 100 km',
            'pref_sex.required' => 'Sex preferences field is required',
            'pref_sex.in' => 'Sex preferences can be only male, female or bisexual',
            'tags.*' => 'Only given tags are available'
        ];
    }
}
