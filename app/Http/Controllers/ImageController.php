<?php

namespace App\Http\Controllers;

use App\Image;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\Request;

class ImageController extends Controller
{

    use ValidatesRequests;

    public function store(Request $request)
    {
        $this->validate($request, [
            'image' => 'image|required|max:1999'
        ]);

        $imageNameWithExt = $request->file('image')->getClientOriginalName();
        $imageName = pathinfo($imageNameWithExt, PATHINFO_FILENAME);
        $imageExtension = $request->file('image')->getClientOriginalExtension();
        $imageNameToStore = $imageName . '_' . time() . '.' . $imageExtension;
        $path = $request->file('image')->storeAs('public/images', $imageNameToStore);
        $image = new Image();
        $image->path = 'storage/images/' . $imageNameToStore;
        $image->save();
    }
}
