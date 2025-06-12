<?php

namespace App\Http\Controllers;

use App\Models\Blog;
use App\Models\Category;
use App\Models\Event;
use App\Models\Gallery;
use App\Models\Project;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function store(Request $request){
        // 1. Valider les données
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        // 2. Créer la catégorie
        $category = Category::create([
            'name' => $request->name,
        ]);

        return response()->json([
            'message' => 'Catégorie créée avec succès.',
            'category' => $category
        ], 200);

    }

    public function index(){
        // 1. Récupérer toutes les catégories
        $categories = Category::with(['events', 'projects', 'blogs', 'galleries'])->get();

        // 2. Retourner la réponse JSON
        return response()->json([
            'categories' => $categories
        ], 200);
    }

    public function show ($id){
        // 1. Récupérer la catégorie par son ID
        $category = Category::with(['events', 'projects', 'blogs', 'galleries'])->find($id);

        // 2. Retourner la réponse JSON
        return response()->json([
            'category' => $category
        ], 200);
    }

    public function update(Request $request, $id){
        $data = Category::find($id);

        $cat = $data->update($request->all());
        return response()->json([
            'message' => 'Catégorie mise à jour avec succès.',
            'category' => $cat
        ], 200);
    }

    public function destroy($id){
        // 1. Récupérer la catégorie par son ID
        $category = Category::find($id);

        // 3. Supprimer la catégorie
        $category->delete();

        // 4. Retourner une réponse de succès
        return response()->json(['message' => 'Catégorie supprimée avec succès.'], 200);
    }

}
