<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    // Gestion des comptes réservée à superadmin et admin ; seul un superadmin touche aux comptes et au rôle superadmin
    private function roleName(?User $user): ?string
    {
        return $user?->loadMissing('role')->role?->name;
    }

    private function isManager(?User $user): bool
    {
        return in_array($this->roleName($user), ['superadmin', 'admin'], true);
    }

    private function superadminRoleId(): ?int
    {
        return \App\Models\Role::where('name', 'superadmin')->value('id');
    }

    private function forbidden()
    {
        return response()->json(['message' => 'You are not allowed to do this.'], 403);
    }

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
        $me = $request->user();
        if (!$this->isManager($me)) {
            return $this->forbidden();
        }
        if ((int) $request->role_id === $this->superadminRoleId() && $this->roleName($me) !== 'superadmin') {
            return $this->forbidden();
        }

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

    // Chacun peut modifier son propre profil ; rôle et activation : superadmin/admin uniquement, jamais sur son propre compte.
    // Le mot de passe ne passe jamais par ici (création : store ; changement : changePassword)
    public function update(Request $request, $id){
        $me = $request->user();
        $data = User::find($id);
        if (!$data) {
            return response()->json(['message' => 'User not found'], 404);
        }

        $isSelf = $me->id === $data->id;
        $isManager = $this->isManager($me);
        $isSuperadmin = $this->roleName($me) === 'superadmin';
        $superadminRole = $this->superadminRoleId();

        if (!$isSelf && !$isManager) {
            return $this->forbidden();
        }
        if (!$isSelf && $data->role_id === $superadminRole && !$isSuperadmin) {
            return $this->forbidden();
        }

        $rules = [
            'nom' => 'sometimes|required|string|max:255',
            'prenom' => 'sometimes|required|string|max:255',
            'email' => ['sometimes', 'required', 'email', 'max:255', Rule::unique('users', 'email')->ignore($data->id)],
            'image' => 'nullable|string|max:255',
            'telephone' => 'nullable|string|max:30',
        ];
        if ($isManager && !$isSelf) {
            $rules['role_id'] = 'sometimes|required|exists:roles,id';
            $rules['is_active'] = 'sometimes|boolean';
        }
        $fields = $request->validate($rules);

        if (isset($fields['role_id']) && (int) $fields['role_id'] === $superadminRole && !$isSuperadmin) {
            return $this->forbidden();
        }

        $user = $data->update($fields);
        return response()->json([
            'user' => $user
        ]);
    }

    public function destroy(Request $request, $id){
        $me = $request->user();
        $data = User::find($id);
        if (!$data) {
            return response()->json(['message' => 'User not found'], 404);
        }
        if (!$this->isManager($me) || $me->id === $data->id) {
            return $this->forbidden();
        }
        if ($data->role_id === $this->superadminRoleId() && $this->roleName($me) !== 'superadmin') {
            return $this->forbidden();
        }

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

        // Compte désactivé dans l'admin : pas de jeton
        if (!$user->is_active) {
            return response()->json([
                "message"=>"This account is disabled"
            ],403);
        }

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
