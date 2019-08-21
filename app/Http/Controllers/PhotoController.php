<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\Request;
use App\Photo;
use App\User;
use Intervention\Image\Facades\Image;

class PhotoController extends Controller
{

    use ValidatesRequests;

    public function show($user)
    {
        $paths = $this->getUserPhotos($user);

        return view('photo.show', [
           'paths' =>  $paths,
        ]);
    }

    public function create()
    {
        return view('photo.create');
    }

    public function store(Request $request)
    {
        $this->validate($request, $this->rules(), $this->errorMessages());

        $this->saveImage($request);

        return redirect("/photos/" . Auth::id());
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {

    }

    public function getUserPhotos($userId)
    {
        return Photo::where('user_id', $userId)->pluck('path');

    }

    public function saveImage(Request $request)
    {
        foreach ($request->file('photo') as $photo) {
            $photoExtension = $photo->getClientOriginalExtension();
            $photoNameToStore = bin2hex(random_bytes(10)) . '.' . $photoExtension;
            $photo->storeAs('public/photos', $photoNameToStore);

            $image = Image::make(public_path("/storage/photos/{$photoNameToStore}"))->fit(480, 640);
            $image->save();

            $newPhoto = new Photo();
            $newPhoto->path = '/storage/photos/' . $photoNameToStore;
            $newPhoto->user_id = Auth::id();
            $newPhoto->save();
        }
    }

    public function rules()
    {
        return [
            'photo' => 'required',
            'photo.*' => 'max:2048|image|mimes:jpeg,png,jpg,svg'
        ];
    }

    public function errorMessages()
    {
        return [
            'photo.required' => 'At least 1 photo is required',
            'photo.*.image' => 'Please upload an image only',
            'photo.*.mimes' => 'Only jpeg, png, jpg and bmp images are allowed',
            'photo.*.max' => 'Sorry! Maximum allowed size for an image is 2MB',
        ];
    }
}
