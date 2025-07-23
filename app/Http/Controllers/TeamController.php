<?php

namespace App\Http\Controllers;

use App\Models\Team;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class TeamController extends Controller
{
    public function indexTeams(){
        $data = Team::where('type', 'teams')->orderBy('id', 'desc')->get();
        return response()->json([
            'status' => 200,
            'teams' => $data,
        ]);
    }

    public function indexAdvisors(){
        $data = Team::where('type', 'advisors')->orderBy('id', 'desc')->get();
        return response()->json([
            'status' => 200,
            'advisors' => $data,
        ]);
    }

    public function show($slug){
        $data = Team::where('slug', $slug)->first();
        if ($data) {
            return response()->json([
                'status' => 200,
                'team' => $data,
            ]);
        } else {
            return response()->json([
                'status' => 404,
                'message' => 'Team not found',
            ]);
        }
    }

    public function store(Request $request){
        $request->validate([
            'name' => 'required|string|max:255',
            'brief_description' => 'nullable|string',
            'content' => 'nullable|string',
            'profession' => 'nullable|string|max:255',
            'image' => 'nullable',
            'type' => 'required|in:teams,advisors',
            'facebook_link' => 'nullable|url',
            'twitter_link' => 'nullable|url',
            'linkedin_link' => 'nullable|url',
            'instagram_link' => 'nullable|url',
        ]);

        // ✅ Générer un slug unique à partir du titre
        $baseSlug = Str::slug($request->name);

        $team =  Team::create([
            'name' => $request->name,
            'slug' => $baseSlug,
            'brief_description' => $request->brief_description,
            'image' => $request->image,
            'content' => $request->content,
            'profession' => $request->profession,
            'type' => $request->type,
            'facebook_link' => $request->facebook_link,
            'twitter_link' => $request->twitter_link,
            'linkedin_link' => $request->linkedin_link,
            'instagram_link' => $request->instagram_link,
        ]);

        return response()->json([
            'status' => 200,
            'message' => 'Team created successfully',
            'team' => $team,
        ]);
    }

    public function update(Request $request, $slug){
        $team = Team::where('slug',$slug)->first();

        $data = $team->update($request->all());

        return response()->json([
            'status' => 200,
            'message' => 'Team updated successfully',
            'team' => $data,
        ]);

    }

    public function destroy($slug){
        $team = Team::where('slug', $slug)->first();
        if (!$team) {
            return response()->json([
                'status' => 404,
                'message' => 'Team not found',
            ]);
        }

        $team->delete();

        return response()->json([
            'status' => 200,
            'message' => 'Team deleted successfully',
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
            $request->file('image')->move(public_path('images/User'), $picName);

            // Retourner l'URL de l'image téléchargée
            return response()->json(['image_url' => "/images/User/$picName"]);

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
