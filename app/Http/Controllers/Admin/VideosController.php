<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Video;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class VideosController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $videos = Video::orderBy('created_at','desc')->paginate(10);
        return view('admin.video.index' ,[
            'videos' => $videos,
            'title' => 'قسم مقاطع الفيديو'
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.video.create', [
            'title' => "اضافة فيديو جديد"
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => ['required'],
            'video_url' => ['required'],
            'image' => ['required', 'image'],
        ]);
        if($request->hasFile('image')){
            $uploadedFile = $request->file('image');
            $image_url = $uploadedFile->store('/','upload');
            $request->merge([
                'image_url' => $image_url
            ]);
        }
        Video::create($request->all());
        return redirect()->route('videos.index')->with(['success' => 'تم اضافة فيديو بنجاح']);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $video = Video::findOrFail($id);
        return view('admin.video.edit',[
            'video' => $video,
            'title' => 'صفحة التعديل'
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $video = Video::findOrFail($id);

        $request->validate([
            'title' => ['required'],
            'video_url' => ['required'],
            'image' => ['nullable', 'image'],
        ]);

       
        if($request->hasFile('image')){
            $uploadedFile = $request->file('image');
            Storage::disk('upload')->delete($video->image_url);
            $image_url = $uploadedFile->store('/','upload');
            $request->merge([
                'image_url' => $image_url
            ]);
        }
        // dd($request);
        $video->update($request->all());
        return redirect()->route('videos.index')->with(['success' => 'تم تعديل فيديو بنجاح']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Video::where('id', '=', $id)->delete();
        return redirect()->route('videos.index')->with(['success' => 'تم حذف فيديو بنجاح']);
    }
}
