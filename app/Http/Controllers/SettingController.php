<?php

namespace App\Http\Controllers;

use App\Models\Setting;
use Illuminate\Http\Request;

// Paramètres du site modifiables dans l'admin : coordonnées, réseaux sociaux, textes de l'accueil
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

        $oldPhoto = Setting::where('key', 'ceo_photo')->value('value');

        foreach (array_keys($rules) as $key) {
            if (array_key_exists($key, $data)) {
                $value = is_string($data[$key]) ? trim($data[$key]) : $data[$key];
                Setting::updateOrCreate(['key' => $key], ['value' => $value === '' ? null : $value]);
            }
        }

        // Ancienne photo téléversée remplacée : on la supprime (les images d'origine du thème sont conservées)
        if (array_key_exists('ceo_photo', $data) && $oldPhoto && $oldPhoto !== $data['ceo_photo']) {
            $this->deletePublicImage($oldPhoto);
        }

        return $this->index();
    }

    public function uploadImg(Request $request){
        $request->validate([
            'image' => 'required|image|mimes:jpeg,png,jpg,webp|max:20480'
        ]);

        $image = $request->file('image');
        $picName = time() . '_' . uniqid() . '.' . $image->extension();
        $this->optimizeImage($image->move(public_path('images/Settings'), $picName)->getPathname(), 800);

        return response()->json(['image_url' => "/images/Settings/$picName"]);
    }

}
