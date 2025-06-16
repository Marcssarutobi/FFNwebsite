<?php

namespace App\Http\Controllers;

use App\Models\Project;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ProjectController extends Controller
{

    public function index(){
        $data = Project::with('category')->orderBy('id','desc')->get();
        return response()->json([
            "data"=>$data
        ]);
    }

    public function allProject () {
        $data = Project::with('category')->orderBy('id','desc')->paginate(6);
        return response()->json([
            "data"=>$data
        ]);
    }

    public function show($id)
    {

        $data = Project::with('category')->find($id);

        if (!$data) {
            return response()->json([
                'error' => 'Projet non trouvé.'
            ], 404);
        }

        return response()->json([
            "data" => $data,
        ]);
    }


    public function showUser($slug){
        $data = Project::with('category')->where('slug',$slug)->first();
        return response()->json([
            "data"=>$data
        ]);
    }

    public function store(Request $request){
        $request->validate([
            'title'=>'required',
            'brief_description'=>'required',
            'content'=>'required',
            'image'=>'required',
            'category_id'=>'required',
            'status'=>'required',
            'user_id'=>'required'
        ]);

        // ✅ Générer un slug unique à partir du titre
        $baseSlug = Str::slug($request->title);

        $project = Project::create([
            'slug' => $baseSlug,
            'title' => $request->title,
            'brief_description' => $request->brief_description,
            'content' => $request->content,
            'image' => $request->image,
            'category_id' => $request->category_id,
            'status' => $request->status,
            'user_id' => $request->user_id
        ]);

        return response()->json([
            "data"=>$project
        ]);

    }

    public function update(Request $request, $id){
        $data = Project::find($id);
        $project = $data->update($request->all());
        return response()->json([
            "data"=>$project
        ]);
    }

    public function destroy($id){
        $data = Project::find($id);
        $project = $data->delete();
        return response()->json([
            "data"=>$project
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
            $request->file('image')->move(public_path('images/Project'), $picName);

            // Retourner l'URL de l'image téléchargée
            return response()->json(['image_url' => "/images/Project/$picName"]);

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
