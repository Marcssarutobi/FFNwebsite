<?php

namespace App\Http\Controllers;

use App\Models\HomeSlide;
use Illuminate\Http\Request;

class HomeSlideController extends Controller
{

    public function index(){
        $slides = HomeSlide::orderBy('position')->get();
        return response()->json([
            "slides"=>$slides
        ]);
    }

    public function update(Request $request, $id){
        $request->validate([
            "image"=>["required","string","max:255","regex:#^/(images/Slider|assets/images/main-slider)/[^/]+$#"]
        ]);

        $slide = HomeSlide::findOrFail($id);
        $oldImage = $slide->image;
        $slide->update(['image' => $request->image]);

        // Les images d'origine du thème (/assets/...) ne sont jamais supprimées : seulement les anciens téléversements
        if ($oldImage !== $slide->image) {
            $this->deletePublicImage($oldImage);
        }

        return response()->json([
            "slide"=>$slide
        ]);
    }

    public function uploadImg(Request $request){
        $request->validate([
            'image' => 'required|image|mimes:jpeg,png,jpg,webp|max:10240'
        ]);

        $image = $request->file('image');
        $picName = time() . '_' . uniqid() . '.' . $image->extension();
        $image->move(public_path('images/Slider'), $picName);

        return response()->json(['image_url' => "/images/Slider/$picName"]);
    }

}
