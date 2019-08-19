<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\Request;
use App\Photo;

class PhotoController extends Controller
{

    use ValidatesRequests;

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('photo.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    
    public function store(Request $request)
    {
        $this->validate($request, [
            'photo' => 'image|required|max:1999'
        ]);
        $photoExtension = $request->file('photo')->getClientOriginalExtension();
        $photoNameToStore = bin2hex(random_bytes(10)) . '.' . $photoExtension;
        $request->file('photo')->storeAs('public/photos', $photoNameToStore);
        $newPhoto = new Photo();
        $newPhoto->path = 'storage/photos/' . $photoNameToStore;
        $newPhoto->user_id = \Auth::user()->id;
        $newPhoto->save();
        return redirect('/home');
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
}
