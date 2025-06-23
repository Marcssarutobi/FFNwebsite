<?php

namespace App\Http\Controllers;

use App\Models\Gallery;
use Illuminate\Http\Request;

class GalleryController extends Controller
{
    
     public function index(){
        $gly = Gallery::orderBy('id','desc')->get();
        return response()->json([
            "gly"=>$gly
        ]);
    }

    public function createGallery(Request $request){
        $request->validate([
            "image"=>"required"
        ]);

        $gly = Gallery::create([
            "image"=>$request->image,

        ]);

        return response()->json([
            "gly"=>$gly
        ]);
    }

    public function showImage($id){
        $gly = Gallery::find($id);
        return response()->json([
            "gly"=>$gly
        ]);
    }

    public function updateImage(Request $request, $id){
        $data = Gallery::find($id);
        $gly = $data->update($request->all());
        return response()->json([
            "gly"=>$gly
        ]);
    }

    public function deleteImage($id){
        $data = Gallery::find($id);
        $gly = $data->delete();
        return response()->json([
            "gly"=>$gly
        ]);
    }

    public function UploadImage(Request $request){
        $request->validate([
            'image.*' => 'required|image|mimes:jpeg,png,jpg,gif'
        ]);

        $imageUrls = [];

        if ($request->hasFile('image')) {
            foreach ($request->file('image') as $image) {
                // Génération d'un nom unique pour l'image
                $picName = time() . '_' . uniqid() . '.' . $image->extension();

                // Déplacement du fichier vers le répertoire public/images/gallery
                $image->move(public_path('images/gallery'), $picName);

                // Ajouter l'URL de l'image téléchargée au tableau
                $imageUrls[] = "/images/gallery/$picName";
            }

            // Retourner les URLs des images téléchargées
            return response()->json(['image_urls' => $imageUrls]);

        } else {
            // Aucun fichier image n'a été téléchargé, retourner une erreur
            return response()->json(['error' => "Aucune image n'a été téléchargée."], 400);
        }
    }

    public function SuppImage(Request $request, $hasFullPath = false){
        $request->validate([
            'image'=>'required'
        ]);

        if (!$hasFullPath) {
            $filePath = public_path() .$request->image;
        }

        if(file_exists($filePath)){
            @unlink($filePath);
        }

        return 'done';
    }

}
