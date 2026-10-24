<?php

namespace App\Http\Controllers;

use App\Models\Setting;
use Illuminate\Http\Request;

// Paramètres du site modifiables dans l'admin : coordonnées, réseaux sociaux, textes de l'accueil, bandeau des articles
class SettingController extends Controller
{
    // Clés autorisées et leurs règles de validation
    private function rules(): array
    {
        $social = ['nullable', 'url', 'max:255', 'regex:#^https://#'];
        return [
            'contact_email' => 'required|email|max:255',
            'contact_phone' => 'required|string|max:60',
            'contact_address' => 'required|string|max:255',
            'social_facebook' => $social,
            'social_x' => $social,
            'social_instagram' => $social,
            'social_linkedin' => $social,
            'facts_title' => 'nullable|string|max:500',
            'facts_text' => 'nullable|string|max:2000',
            'ceo_message' => 'nullable|string|max:3000',
            'ceo_name' => 'nullable|string|max:120',
            'ceo_role' => 'nullable|string|max:120',
            'ceo_photo' => ['nullable', 'string', 'max:255', 'regex:#^/(images/Settings|assets/images/resource)/[^/]+$#'],
            // Bandeau « Every mushroom matters » en bas des articles de blog
            'parallax_image' => ['nullable', 'string', 'max:255', 'regex:#^/(images/Settings|assets/images/parallax)/[^/]+$#'],
            'parallax_title_start' => 'nullable|string|max:60',
            'parallax_title_highlight' => 'nullable|string|max:60',
            'parallax_title_end' => 'nullable|string|max:60',
            'parallax_text' => 'nullable|string|max:300',
        ];
    }

    public function index(){
        $settings = Setting::whereIn('key', array_keys($this->rules()))->pluck('value', 'key');
        return response()->json([
            "settings"=>$settings
        ]);
    }

    public function update(Request $request){
        $rules = $this->rules();
        $data = $request->validate($rules);

        // Images téléversées : l'ancienne est supprimée quand elle est remplacée
        $imageKeys = ['ceo_photo', 'parallax_image'];
        $oldImages = Setting::whereIn('key', $imageKeys)->pluck('value', 'key');

        foreach (array_keys($rules) as $key) {
            if (array_key_exists($key, $data)) {
                $value = is_string($data[$key]) ? trim($data[$key]) : $data[$key];
                Setting::updateOrCreate(['key' => $key], ['value' => $value === '' ? null : $value]);
            }
        }

        // (les images d'origine du thème, hors public/images, sont conservées par deletePublicImage)
        foreach ($imageKeys as $key) {
            $old = $oldImages[$key] ?? null;
            if (array_key_exists($key, $data) && $old && $old !== $data[$key]) {
                $this->deletePublicImage($old);
            }
        }

        return $this->index();
    }

    public function uploadImg(Request $request){
        $request->validate([
            'image' => 'required|image|mimes:jpeg,png,jpg,webp|max:20480'
        ]);

        $image = $request->file('image');
        $picName = time() . '_' . uniqid() . '.' . $image->extension();
        // Image de fond : pleine largeur ; photo du CEO : petite
        $maxSide = $request->input('target') === 'parallax' ? 1920 : 800;
        $this->optimizeImage($image->move(public_path('images/Settings'), $picName)->getPathname(), $maxSide);

        return response()->json(['image_url' => "/images/Settings/$picName"]);
    }

}
