<?php

namespace App\Http\Controllers;

use App\Models\Event;
use Illuminate\Http\Request;
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
            'end_date'=>'required',
            'location'=>'required',
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
            'brief_description' => $request->brief_description,
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


}
