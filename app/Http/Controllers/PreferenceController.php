<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePreferences;
use App\Http\Requests\UpdatePreferences;
use Illuminate\Support\Facades\Auth;
use App\Preference;


class PreferenceController extends Controller
{
    protected $preferencesModel;

    public function __construct(Preference $model){
        $this->preferencesModel = $model;
    }

    public function index()
    {
        return response()->json(array('pref' => $this->preferencesModel->getById(Auth::id())));
    }


    public function create()
    {
        return view('preferences.create');
    }


    public function store(StorePreferences $request)
    {
        $this->preferencesModel->saveWithId($request->input(), Auth::id());
        return redirect("/recs");
    }


    public function edit()
    {
        $preference = $this->preferencesModel->getById(Auth::id());
        return view('preferences.edit', compact('preference'));
    }


    public function update(UpdatePreferences $request)
    {
        $this->preferencesModel->updateWithId($request->input(), Auth::id());
    }
}
