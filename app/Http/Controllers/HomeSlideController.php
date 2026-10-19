<?php

namespace App\Http\Controllers;

use App\Models\HomeSlide;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class HomeSlideController extends Controller
{

    public function index(){
        $slides = HomeSlide::orderBy('position')->orderBy('id')->get();
        return response()->json([
            "slides"=>$slides
        ]);
    }

    private function rules(): array
    {
        return [
            "image"=>["required","string","max:255","regex:#^/(images/Slider|assets/images/main-slider)/[^/]+$#"],
            "title_light"=>"nullable|string|max:255",
            "title"=>"nullable|string|max:255",
            "subtitle"=>"nullable|string|max:255",
            "text"=>"nullable|string|max:1000",
            "button_label"=>"nullable|string|max:60",
            // Lien interne (/contact) ou externe (https://...)
            "button_link"=>["nullable","string","max:255","regex:#^(/(?!/)|https?://)#"],
        ];
    }

    public function store(Request $request){
        $data = $request->validate($this->rules());
        $data['position'] = (int) HomeSlide::max('position') + 1;
        $slide = HomeSlide::create($data);

        return response()->json([
            "slide"=>$slide
        ]);
    }

    public function update(Request $request, $id){
        $request->validate($this->rules());

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

    public function destroy($id){
        // Le diaporama doit garder au moins une diapositive
        if (HomeSlide::count() <= 1) {
            return response()->json(["message"=>"The slider must keep at least one slide."], 422);
        }

        $slide = HomeSlide::findOrFail($id);
        $this->deletePublicImage($slide->image);
        $slide->delete();

        return response()->json([
            "deleted"=>true
        ]);
    }

    // Nouvel ordre d'affichage : liste complète des identifiants, dans l'ordre voulu
    public function reorder(Request $request){
        $request->validate([
            'ids' => 'required|array',
            'ids.*' => 'integer|exists:home_slides,id',
        ]);

        DB::transaction(function () use ($request) {
            foreach (array_values($request->ids) as $index => $id) {
                HomeSlide::where('id', $id)->update(['position' => $index + 1]);
            }
        });

        return $this->index();
    }

    public function uploadImg(Request $request){
        $request->validate([
            'image' => 'required|image|mimes:jpeg,png,jpg,webp|max:10240'
        ]);

        $image = $request->file('image');
        $picName = time() . '_' . uniqid() . '.' . $image->extension();
        $this->optimizeImage($image->move(public_path('images/Slider'), $picName)->getPathname(), 2400);

        return response()->json(['image_url' => "/images/Slider/$picName"]);
    }

}
