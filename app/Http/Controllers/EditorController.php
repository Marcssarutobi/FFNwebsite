<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class EditorController extends Controller
{

    // Images insérées dans l'éditeur TinyMCE (réponse au format attendu par TinyMCE : { location })
    public function uploadImage(Request $request){
        $request->validate([
            'file' => 'required|image|mimes:jpeg,png,jpg,gif,webp|max:5048'
        ]);

        $image = $request->file('file');
        $picName = time() . '_' . uniqid() . '.' . $image->extension();
        $image->move(public_path('images/Editor'), $picName);

        return response()->json(['location' => "/images/Editor/$picName"]);
    }

}
