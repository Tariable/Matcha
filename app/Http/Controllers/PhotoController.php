<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePhoto;
use App\Profile;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\Request;
use App\Photo;
use App\User;
use Intervention\Image\Facades\Image;

class PhotoController extends Controller
{

    use ValidatesRequests;

    public function show(User $user)
    {
        $photos = $this->getUserPhotos($user->id);
        return response()->json($photos);
    }

    public function showTheLastOne(User $user)
    {
        $photo = Photo::where('user_id', $user->id)->orderBy('id', 'desc')->first();
        return response()->json($photo);
    }

    public function create()
    {
        $profileId = Auth::id();
        return view('photo.create', compact('profileId'));
    }

    public function store(StorePhoto $request)
    {
        $this->saveImage($request);
        return response()->json(array('message' => 'successful photo store'));
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
        return Photo::where('user_id', $userId)->get();
    }

    public function saveImage(Request $request)
    {
        $photo = $request->file('photo');
        $photoExtension = $photo->getClientOriginalExtension();
        $photoNameToStore = bin2hex(random_bytes(10)) . '.' . $photoExtension;
        $photo->storeAs('public/photos', $photoNameToStore);

        $image = Image::make(public_path("/storage/photos/{$photoNameToStore}"))->fit(480, 640);
        $image->save();

        Photo::create([
            'user_id' => Auth::id(),
            'path' => '/storage/photos/' . $photoNameToStore,
        ]);
    }

    public function rules()
    {
        return [
            'photo' => 'max:2048|image|mimes:jpeg,png,jpg,svg'
        ];
    }

    public function errorMessages()
    {
        return [
            'photo' => 'Please upload an image only',
            'photo.mimes' => 'Only jpeg, png, jpg and bmp images are allowed',
            'photo.max' => 'Sorry! Maximum allowed size for an image is 2MB',
        ];
    }
}
