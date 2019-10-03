<?php

namespace App\Http\Controllers;

use App\Http\Requests\ValidatePreferences;
use App\Http\Requests\UpdatePreferences;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Preference;


class PreferenceController extends Controller
{
    protected $preferencesModel;

    public function __construct(Preference $model)
    {
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

    public function store(ValidatePreferences $request)
    {
        $this->preferencesModel->saveWithId($request->input(), Auth::id());
        return redirect("/recs");
    }

    public function edit()
    {
        $preference = $this->preferencesModel->getById(Auth::id());
        return view('preferences.edit', compact('preference'));
    }

    public function update(ValidatePreferences $request)
    {
        $this->preferencesModel->updateWithId($request->input(), Auth::id());
    }
}
