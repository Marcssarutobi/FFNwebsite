<?php

namespace App\Http\Controllers;

use App\Models\Blog;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class BlogController extends Controller
{
    public function index(){
        $data = Blog::with('category')->orderBy('id','desc')->get();
        return response()->json([
            "data"=>$data
        ]);
    }

    public function allBlog () {
        $data = Blog::with('category')->orderBy('id','desc')->paginate(9);
        return response()->json([
            "data"=>$data
        ]);
    }

    public function show($id){
        $data = Blog::with('category')->find($id);
        return response()->json([
            "data"=>$data
        ]);
    }

    public function showUser($slug){
        $data = Blog::with('category')->where('slug',$slug)->first();
        return response()->json([
            "data"=>$data
        ]);
    }

    public function store(Request $request){
        $request->validate([
            'title'=>'required',
            'brefdescription'=>'required',
            'content'=>'required',
            'image'=>'required',
            'category_id'=>'required',
            'status'=>'required',
            'user_id'=>'required'
        ]);

        // ✅ Générer un slug unique à partir du titre
        $baseSlug = Str::slug($request->title);

        $Blog = Blog::create([
            'slug' => $baseSlug,
            'title' => $request->title,
            'brief_description' => $request->brief_description,
            'content' => $request->content,
            'image'=>$request->image,
            'category_id'=>$request->category_id,
            'status'=>$request->status,
            'user_id'=>$request->user_id
        ]);

        return response()->json([
            "data"=>$Blog
        ]);

    }

    public function update(Request $request, $id){
        $data = Blog::find($id);
        $Blog = $data->update($request->all());
        return response()->json([
            "data"=>$Blog
        ]);
    }

    public function destroy($id){
        $data = Blog::find($id);
        $Blog = $data->delete();
        return response()->json([
            "data"=>$Blog
        ]);
    }
}
