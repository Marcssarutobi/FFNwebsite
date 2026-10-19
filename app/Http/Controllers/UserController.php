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
            $picName = time() . '_' . uniqid() . '.' . $request->file('image')->extension();

            // Déplacement du fichier vers le répertoire public/images
            $this->optimizeImage($request->file('image')->move(public_path('images/Profils'), $picName)->getPathname());

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

        $this->deletePublicImage($request->image);

        return 'done';

    }

    // Changement du mot de passe de l'utilisateur connecté ({id} conservé dans l'URL pour compatibilité, mais ignoré :
    // on ne peut changer que son propre mot de passe)
    public function changePassword(Request $request, $id = null){
        $request->validate([
            "current_password" => "required|string",
            "new_password" => "required|string|min:8|max:255|confirmed|different:current_password",
        ], [
            "new_password.min" => "The new password must be at least 8 characters.",
            "new_password.confirmed" => "The two new passwords do not match.",
            "new_password.different" => "The new password must be different from the current one.",
        ]);

        $user = $request->user();

        if (!Hash::check($request->current_password, $user->password)) {
            return response()->json([
                "message" => "The current password is incorrect.",
                "errors" => ["current_password" => ["The current password is incorrect."]],
            ], 422);
        }

        $user->update([
            "password" => Hash::make($request->new_password),
        ]);

        // Déconnecte les autres appareils / sessions ; la session en cours reste ouverte
        $current = $user->currentAccessToken();
        $user->tokens()->when($current, fn ($query) => $query->where("id", "!=", $current->id))->delete();

        return response()->json([
            "message" => "Your password has been changed.",
        ]);
    }



}
