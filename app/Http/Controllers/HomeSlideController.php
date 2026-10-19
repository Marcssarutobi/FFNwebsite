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
            "image"=>["required","string","max:255","regex:#^/(images/Slider|assets/images/main-slider)/[^/]+$#"],
            "title_light"=>"nullable|string|max:255",
            "title"=>"nullable|string|max:255",
            "subtitle"=>"nullable|string|max:255",
            "text"=>"nullable|string|max:1000",
            "button_label"=>"nullable|string|max:60",
            // Lien interne (/contact) ou externe (https://...)
            "button_link"=>["nullable","string","max:255","regex:#^(/(?!/)|https?://)#"],
        ]);

        $slide = HomeSlide::findOrFail($id);
        $oldImage = $slide->image;
        $slide->update($request->only(["image","title_light","title","subtitle","text","button_label","button_link"]));

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
