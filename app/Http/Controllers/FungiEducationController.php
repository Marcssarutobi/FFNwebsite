<?php

namespace App\Http\Controllers;

use App\Models\FungiEducation;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

use App\Http\Controllers\Controller;

class FungiEducationController extends Controller
{
    //
    public function index(){
        $data = FungiEducation::with('user')->orderBy('id','desc')->get();
        return response()->json([
            "data"=>$data
        ]);
    }

    public function allFungiEducation () {
        $data = FungiEducation::with('user')->orderBy('id','desc')->paginate(6);
        return response()->json([
            "data"=>$data
        ]);
    }

    public function show($id)
    {
        $data = FungiEducation::find($id);

        if (!$data) {
            return response()->json([
                'error' => 'Fungi Education not found.'
            ], 404);
        }

        return response()->json([
            "data" => $data,
        ]);
    }

    public function showUser($slug){
        $data = FungiEducation::with('user')->where('slug',$slug)->first();
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
            'user_id'=>'required',
        ]);

       // ✅ Générer un slug unique à partir du titre
        $baseSlug = Str::slug($request->title);

        $fungiEducation = FungiEducation::create([
            'slug' => $baseSlug,
            'title' => $request->title,
            'brief_description' => $request->brief_description,
            'content' => $request->content,
            'image' => $request->image,
            'user_id' => $request->user_id
        ]);
        return response()->json([
            "data" => $fungiEducation,
            "message" => "Fungi Education created successfully."
        ]);

    }

    public function update(Request $request, $id){
        $data = FungiEducation::find($id);
        $education = $data->update($request->all());
        return response()->json([
            "data"=>$education
        ]);
    }

    public function destroy($id){
        $data = FungiEducation::find($id);
        $education = $data->delete();
        return response()->json([
            "data"=>$education
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
            $request->file('image')->move(public_path('images/FungiEducation'), $picName);

            // Retourner l'URL de l'image téléchargée
            return response()->json(['image_url' => "/images/FungiEducation/$picName"]);

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
