<?php

namespace App\Http\Controllers;

use App\Models\Partner;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

// Logos de la section « Our Partners & Supporters »
class PartnerController extends Controller
{
    private function rules(): array
    {
        return [
            'name' => 'required|string|max:255',
            'logo' => ['required', 'string', 'max:255', 'regex:#^/(images/Partners|assets/images/clients)/[^/]+$#'],
            'url' => ['nullable', 'url', 'max:255', 'regex:#^https?://#'],
        ];
    }

    public function index(){
        $partners = Partner::orderBy('position')->orderBy('id')->get();
        return response()->json([
            "partners"=>$partners
        ]);
    }

    public function store(Request $request){
        $data = $request->validate($this->rules());
        $data['position'] = (int) Partner::max('position') + 1;
        $partner = Partner::create($data);

        return response()->json([
            "partner"=>$partner
        ]);
    }

    public function update(Request $request, $id){
        $data = $request->validate($this->rules());
        $partner = Partner::findOrFail($id);
        $oldLogo = $partner->logo;
        $partner->update($data);

        if ($oldLogo !== $partner->logo) {
            $this->deletePublicImage($oldLogo);
        }

        return response()->json([
            "partner"=>$partner
        ]);
    }

    public function destroy($id){
        $partner = Partner::findOrFail($id);
        $this->deletePublicImage($partner->logo);
        $partner->delete();

        return response()->json([
            "deleted"=>true
        ]);
    }

    // Nouvel ordre d'affichage : liste complète des identifiants, dans l'ordre voulu
    public function reorder(Request $request){
        $request->validate([
            'ids' => 'required|array',
            'ids.*' => 'integer|exists:partners,id',
        ]);

        DB::transaction(function () use ($request) {
            foreach (array_values($request->ids) as $index => $id) {
                Partner::where('id', $id)->update(['position' => $index + 1]);
            }
        });

        return $this->index();
    }

    public function uploadImg(Request $request){
        $request->validate([
            'image' => 'required|image|mimes:jpeg,png,jpg,webp|max:20480'
        ]);

        $image = $request->file('image');
        $picName = time() . '_' . uniqid() . '.' . $image->extension();
        $this->optimizeImage($image->move(public_path('images/Partners'), $picName)->getPathname(), 600);

        return response()->json(['image_url' => "/images/Partners/$picName"]);
    }

}
