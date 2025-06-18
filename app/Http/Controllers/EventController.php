<?php

namespace App\Http\Controllers;

use App\Mail\ApprobationMail;
use App\Models\Event;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class EventController extends Controller
{

    public function index(){
        $data = Event::with('category')->orderBy('id','desc')->get();
        return response()->json([
            "data"=>$data
        ]);
    }

    public function allEvent () {
        $data = Event::with('category')->orderBy('id','desc')->paginate(9);
        return response()->json([
            "data"=>$data
        ]);
    }

    public function show($id){
        $data = Event::with('category')->find($id);
        return response()->json([
            "data"=>$data
        ]);
    }

    public function showUser($slug){
        $data = Event::with('category')->where('slug',$slug)->first();
        return response()->json([
            "data"=>$data
        ]);
    }

    public function store(Request $request){
        $request->validate([
            'title'=>'required',
            'brefdescription'=>'required',
            'content'=>'required',
            'start_date'=>'required',
            'image'=>'required',
            'category_id'=>'required',
            'status'=>'required',
            'user_id'=>'required'
        ]);

        // ✅ Générer un slug unique à partir du titre
        $baseSlug = Str::slug($request->title);

        $Event = Event::create([
            'slug' => $baseSlug,
            'title' => $request->title,
            'brefdescription' => $request->brefdescription,
            'content' => $request->content,
            'start_date'=>$request->start_date,
            'end_date'=>$request->end_date,
            'location'=>$request->location,
            'image' => $request->image,
            'category_id'=>$request->category_id,
            'status'=>$request->status,
            'user_id'=>$request->user_id,
        ]);

        return response()->json([
            "data"=>$Event
        ]);

    }

    public function update(Request $request, $id){
        $data = Event::find($id);
        $Event = $data->update($request->all());
        return response()->json([
            "data"=>$Event
        ]);
    }

    public function destroy($id){
        $data = Event::find($id);
        $Event = $data->delete();
        return response()->json([
            "data"=>$Event
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
            $request->file('image')->move(public_path('images/Events'), $picName);

            // Retourner l'URL de l'image téléchargée
            return response()->json(['image_url' => "/images/Events/$picName"]);

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

    public function SendApprobationMail($id){
        $event = Event::find($id);
        $user = User::whereHas('role',function($query){
            $query->where('name','approver');
        })->first();

        if (!$event || !$user) {
            return response()->json([
                'error' => 'Événement ou utilisateur non trouvé.'
            ], 404);
        }

        $dataId = $event->id;
        $subject = "Approval of a new event";
        $message = "A new event has been created and needs your approval. <br><br>" .
           "Please click the link below to review the event: <br><br>" .
           "<a href='" . url("/eventpreview/$dataId") . "'>View Event</a><br><br>" .
           "Thank you for your attention.";

        try {

            Mail::to($user->email)->send(new ApprobationMail($subject, $message));

            return response()->json([
                'message' => 'Email sent successfully.',
                "data"=> $event
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Mail error: ' . $e->getMessage(),
            ], 500);
        }

    }

    public function SendDeclenedMail($id, Request $request){
        $request->validate([
            'reason' => 'required|string|max:1000',
        ]);

        $event = Event::find($id);
        $user = User::whereHas('role',function($query){
            $query->where('name','author');
        })->where('id',$event->user_id)->first();

        if (!$event || !$user) {
            return response()->json([
                'error' => 'Événement ou utilisateur non trouvé.'
            ], 404);
        }
        $title = $event->title;
        $subject = "Event Rejected";
        $reasons = $request->reason;
        $message = "The event article <strong>" . $title . "</strong> has been rejected. <br><br>" .
           "Here are the reasons: <br><br>" .
            $reasons ."<br><br>" .
           "Thank you for your attention.";

        try {

            Mail::to($user->email)->send(new ApprobationMail($subject, $message));

            return response()->json([
                'message' => 'Email sent successfully.',
                "data"=> $event
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Mail error: ' . $e->getMessage(),
            ], 500);
        }
    }


}
