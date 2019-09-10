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
    public function index()
    {
        $data = Preference::whereId(Auth::id())->first();
        return response()->json(array('pref' => $data));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('preferences.create');
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
        $data['id'] = Auth::id();
        Preference::create($data);
        return redirect("/recs");
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit()
    {
        $preference = Preference::whereId(Auth::id())->get()->first();
        return view('preferences.edit', compact('preference'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update($id)
    {
        if(!($_SERVER['CONTENT_TYPE'] == 'application/x-www-form-urlencoded')) {
            $data = request()->validate($this->ajaxRules(), $this->errorMessages());
            $data['id'] = Auth::id();
            $preferences = Preference::whereId($id)->get()->first();
            $preferences->update($data);
        } else {
            $data = request()->validate($this->rules(), $this->errorMessages());
            $data['id'] = Auth::id();
            $preferences = Preference::whereId($id)->get()->first();
            $preferences->update($data);
            return redirect("/recs");
        }
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
