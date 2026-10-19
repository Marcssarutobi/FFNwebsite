<?php

namespace App\Http\Controllers;

use App\Models\Video;
use Illuminate\Http\Request;

class VideoController extends Controller
{

    public function index(){
        $videos = Video::orderBy('id','desc')->get();
        return response()->json([
            "videos"=>$videos
        ]);
    }

    public function store(Request $request){
        $request->validate([
            "title"=>"required|string|max:255",
            "description"=>"nullable|string",
            "video_url"=>"nullable|url|max:255|required_without:video_file",
            "video_file"=>"nullable|string|max:255|required_without:video_url",
        ]);

        $video = Video::create($request->only(['title','description','video_url','video_file']));

        return response()->json([
            "video"=>$video
        ]);
    }

    public function update(Request $request, $id){
        $request->validate([
            "title"=>"required|string|max:255",
            "description"=>"nullable|string",
            "video_url"=>"nullable|url|max:255",
        ]);

        $video = Video::findOrFail($id);
        $video->update($request->only(['title','description','video_url']));

        return response()->json([
            "video"=>$video
        ]);
    }

    public function destroy($id){
        $video = Video::findOrFail($id);

        if ($video->video_file) {
            $this->removeFile($video->video_file);
        }
        $video->delete();

        return response()->json([
            "deleted"=>true
        ]);
    }

    public function uploadVideo(Request $request){
        $request->validate([
            // 500 Mo maximum (taille en kilo-octets)
            'video' => 'required|file|mimetypes:video/mp4,video/webm,video/quicktime|max:512000'
        ]);

        $video = $request->file('video');
        $videoName = time() . '_' . uniqid() . '.' . $video->extension();
        $video->move(public_path('images/Videos'), $videoName);

        return response()->json(['video_file' => "/images/Videos/$videoName"]);
    }

    public function deleteVideoFile(Request $request){
        $request->validate([
            'video_file'=>'required|string'
        ]);

        $this->removeFile($request->video_file);

        return 'done';
    }

    // Ne supprime que des fichiers situés dans public/images/Videos
    private function removeFile($path){
        $filePath = public_path('images/Videos/' . basename($path));
        if (file_exists($filePath)) {
            @unlink($filePath);
        }
    }

}
