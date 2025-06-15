<?php

namespace App\Http\Controllers;

use App\Models\Project;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ProjectController extends Controller
{

    public function index(){
        $data = Project::with('category')->orderBy('id','desc')->get();
        return response()->json([
            "data"=>$data
        ]);
    }

    public function allProject () {
        $data = Project::with('category')->orderBy('id','desc')->paginate(6);
        return response()->json([
            "data"=>$data
        ]);
    }

    public function show($id){
        $data = Project::with('category')->find($id);
        return response()->json([
            "data"=>$data
        ]);
    }

    public function showUser($slug){
        $data = Project::with('category')->where('slug',$slug)->first();
        return response()->json([
            "data"=>$data
        ]);
    }

    public function store(Request $request){
        $request->validate([
            'title'=>'required',
            'brief_description'=>'required',
            'content'=>'required',
            'image'=>'required',
            'category_id'=>'required',
            'status'=>'required',
            'user_id'=>'required'
        ]);

        // ✅ Générer un slug unique à partir du titre
        $baseSlug = Str::slug($request->title);

        $project = Project::create([
            'slug' => $baseSlug,
            'title' => $request->title,
            'brief_description' => $request->brief_description,
            'content' => $request->content,
            'image' => $request->image,
            'category_id' => $request->category_id,
            'status' => $request->status,
            'user_id' => $request->user_id
        ]);

        return response()->json([
            "data"=>$project
        ]);

    }

    public function update(Request $request, $id){
        $data = Project::find($id);
        $project = $data->update($request->all());
        return response()->json([
            "data"=>$project
        ]);
    }

    public function destroy($id){
        $data = Project::find($id);
        $project = $data->delete();
        return response()->json([
            "data"=>$project
        ]);
    }

}
