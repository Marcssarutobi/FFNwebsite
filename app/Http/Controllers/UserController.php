<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{

    public function index(){
        $user = User::with('role')->orderBy('id','desc')->get();
        return response()->json([
            'users' => $user
        ]);
    }

    public function show($id){
        $user = User::with('role')->find($id);
        if (!$user) {
            return response()->json(['message' => 'User not found'], 404);
        }
        return response()->json([
            'user' => $user
        ]);
    }

    public function store(Request $request){
        $request->validate([
            'nom' => 'required|string|max:255',
            'prenom' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:8|confirmed',
            'image' => 'nullable|string',
            'telephone' => 'nullable|string|max:15',
            'role_id' => 'required|exists:roles,id',
        ]);

        $user = User::create([
            'nom' => $request->nom,
            'prenom' => $request->prenom,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'image' => $request->image,
            'telephone' => $request->telephone,
            'role_id' => $request->role_id,
        ]);
        return response()->json([
            'user' => $user
        ]);
    }

    public function update(Request $request, $id){
        $data = User::find($id);
        $user = $data->update($request->all());
        return response()->json([
            'user' => $user
        ]);
    }

    public function destroy($id){
        $data = User::find($id);
        $user = $data->delete();
        return response()->json([
            'user' => $user
        ]);
    }

    public function login(Request $request){
        $request->validate([
            "email"=>"required",
            "password"=>"required",
        ]);



        $credentials = $request->only('email', 'password');

        if (!Auth::attempt($credentials)) {
           return response()->json([
            "message"=>"Identifiants incorrects"
           ],401);
        }

        $user = Auth::user();
        $token = $user->createToken('auth_token')->plainTextToken;



        return response()->json([
            'message'=>'Connexion réussie',
            'user'=>$user,
            'token' => $token
        ]);
    }

    public function getUser(Request $request){
        $user = User::with('role')->find(Auth::id());
        return response()->json([
            "user" => $user,
        ]);
    }

    public function logout(Request $request){
        $user = Auth::user();
        if ($user) {

            $request->user()->currentAccessToken()->delete();

            return response()->json([
                "message"=>"Deconnexion"
            ],200);
        }
    }

    public function uploadImg(Request $request){ # Uploder une image dans un dossier

        $request->validate([
            'image' => 'required|image|mimes:jpeg,png,jpg,gif'
        ]);

        if ($request->hasFile('image')) {

            // Génération d'un nom unique pour l'image
            $picName = time() . '.' . $request->file('image')->extension();

            // Déplacement du fichier vers le répertoire public/images
            $request->file('image')->move(public_path('images/Profils'), $picName);

            // Retourner l'URL de l'image téléchargée
            return response()->json(['image_url' => "/images/Profils/$picName"]);

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

    public function changePassword(Request $request,$id){
        $request->validate([
            "current_password"=>"required",
            "new_password"=>"required|confirmed"
        ]);

         // Récupérer l'utilisateur par son ID
        $user = User::find($id);

        if (!Hash::check($request->current_password, $user->password)) {
            return response()->json([
                'error'=>'Le mot de passe actuel est incorrect.'
            ],403);
        }

        $user->update([
            'password' => Hash::make($request->new_password),
        ]);

        // Retourner une réponse de succès
        return response()->json([
            'message' => 'Le mot de passe a été changé avec succès.'
        ]);

    }



}
