<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ExpeditionsController extends Controller
{
    //
    public function index(){
        $data = Expeditions::orderBy('id','desc')->get();
        return response()->json([
            "data"=>$data
        ]);
    }

    public function allExpeditions () {
        $data = Expeditions::orderBy('id','desc')->paginate(6);
        return response()->json([
            "data"=>$data
        ]);
    }

    public function show($id)
    {
        $data = Expeditions::find($id);

        if (!$data) {
            return response()->json([
                'error' => 'Expedition not found.'
            ], 404);
        }

        return response()->json([
            "data" => $data,
        ]);
    }

    public function showUser($slug){
        $data = Expeditions::where('slug',$slug)->first();
        return response()->json([
            "data"=>$data
        ]);
    }

    public function store(Request $request){
        $request->validate([
            'brefdescription'=>'required',
            'start_date'=>'required',
            'end_date'=>'required',
            'location'=>'required',
            'image'=>'required',
            'bailleur'=>'required',
            'user_id'=>'required'
        ]);

        // ✅ Générer un slug unique à partir du titre
        $baseSlug = Str::slug($request->brefdescription);

        $Expedition = Expeditions::create([
            'slug' => $baseSlug,
            'brefdescription' => $request->brefdescription,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
            'location' => $request->location,
            'image' => $request->image,
            'bailleur' => $request->bailleur,
            'user_id' => $request->user_id
        ]);

        return response()->json([
            "data" => $Expedition
        ]);
    }

    public function update(Request $request, $id){
        $data = Expeditions::find($id);
        $expeditions = $data->update($request->all());
        return response()->json([
            "data"=>$expeditions
        ]);
    }

    public function destroy($id){
        $data = Event::find($id);
        $expeditions = $data->delete();
        return response()->json([
            "data"=>$expeditions
        ]);
    }

    public function uploadImg(Request $request){ # Uploder une image dans un dossier

        $request->validate([
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:5048'
        ]);

        if ($request->hasFile('image')) {

            // Génération d'un nom unique pour l'image
            $picName = time() . '.' . $request->file('image')->extension();

            // Déplacement du fichier vers le répertoire public/images
            $request->file('image')->move(public_path('images/Expeditions'), $picName);

            // Retourner l'URL de l'image téléchargée
            return response()->json(['image_url' => "/images/Expeditions/$picName"]);

        } else {
            // Aucun fichier image n'a été téléchargé, retourner une erreur
            return response()->json(['error' => "Aucune image n'a été téléchargée."], 400);
        }

    }

    public function deleteImage(Request $request, $hasFullPath = false){

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
