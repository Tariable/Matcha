<?php

namespace App\Http\Controllers;

use App\Profile;
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
        return view('preferences.create', compact('tags'));
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
        $this->storePreferences($data);
        return redirect("/recs");
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

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit()
    {
        $tags = Tag::all()->pluck('name');
        $preference = Preference::whereId(Auth::id())->get()->first();
        return view('preferences.edit', compact('preference', 'tags'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $data = $this->validate($request, $this->rules(), $this->errorMessages());
        $preferences = Preference::where('id', Auth::id())->get()->first();
        $this->editPreferences($preferences, $data);
        return redirect("/recs");
    }



    public function storePreferences($data)
    {
        $data['id'] = Auth::id();
        $data['tags'] = (isset($data['tags'])) ? serialize($data['tags']) : 0;
        Preference::create($data);
    }

    public function editPreferences(Preference $preferences, $data)
    {
        $data['id'] = Auth::id();
        $data['tags'] = (isset($data['tags'])) ? serialize($data['tags']) : 0;
        $preferences->update($data);
    }

    public function rules()
    {

        return [
            'lowerAge' => 'required|numeric|min:18|max:97',
            'upperAge' => 'required|numeric|min:21|max:100',
            'distance' => 'required|numeric|min:3|max:100',
            'sex' => ['required',
                            Rule::in(['female', 'male', '%ale']),],
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
            'sex.required' => 'Sex preferences field is required',
            'sex.in' => 'Sex preferences can be only male, female or bisexual',
            'tags.*' => 'Only given tags are available'
        ];
    }

}
