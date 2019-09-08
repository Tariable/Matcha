<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePhoto;
use App\Profile;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\Request;
use App\Photo;
use App\User;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;

class PhotoController extends Controller
{

    use ValidatesRequests;

    public function show(User $user)
    {
        $photos = $this->getUserPhotos($user->id);
        return response()->json($photos);
    }


    public function store(StorePhoto $request)
    {
        $statusOfSaving = $this->saveImage($request);
        return response()->json(array('message' => $statusOfSaving));
    }


    public function destroy($id)
    {
        $this->destroyImage($id);
    }

    public function showTheLastOne(User $user)
    {
        $photo = Photo::where('user_id', $user->id)->orderBy('id', 'desc')->first();
        return response()->json($photo);
    }

    public function getUserPhotos($userId)
    {
        return Photo::where('user_id', $userId)->get();
    }

//????????????????????????????????? Move to model ????????????????????????????????????????????????

    public function destroyImage($id)
    {
        $path = Photo::where('id', $id)->pluck('path')->first();
        $path = substr($path, strpos($path, '/', 1));
        Storage::delete('public' . $path);
        Photo::where('id', $id)->delete();
    }

    public function saveImage(Request $request)
    {
        if (Photo::where('user_id', Auth::id())->count() < 5){
            $photo = $request->file('photo');
            $photoExtension = $photo->getClientOriginalExtension();
            $photoNameToStore = bin2hex(random_bytes(10)) . '.' . $photoExtension;
            $photo->storeAs('public/photos', $photoNameToStore);

            $image = Image::make(public_path("/storage/photos/{$photoNameToStore}"))->fit(480, 640);
            $image->save();

            Photo::create([
                'user_id' => Auth::id(),
                'path' => 'public/storage/photos/' . $photoNameToStore,
            ]);
            return 'success';
        } else {
            abort(422);
        }
    }
}
