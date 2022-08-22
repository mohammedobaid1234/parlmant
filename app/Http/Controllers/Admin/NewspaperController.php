<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Newspaper;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class NewspaperController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $newspapers = Newspaper::orderBy('created_at','desc')->paginate(10);
        return view('admin.newspaper.index' ,[
            'newspapers' => $newspapers,
            'title' => 'قسم الجريدة الكترونية'
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.newspaper.create', [
            'title' => "اضافة جريدة الكترونية جديد"
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
            'newspaper_url' => ['required'],
            'image' => ['required', 'image'],
        ]);
        if($request->hasFile('image')){
            $uploadedFile = $request->file('image');
            $image_url = $uploadedFile->store('/','upload');
            $request->merge([
                'image_url' => $image_url
            ]);
        }
        
        Newspaper::create($request->all());
        return redirect()->route('newspapers.index')->with(['success' => 'تم اضافة الجريدة الالكترونية بنجاح']);
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
        $newspaper = Newspaper::findOrFail($id);
        return view('admin.newspaper.edit',[
            'newspaper' => $newspaper,
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
        $newspaper = Newspaper::findOrFail($id);

        $request->validate([
            'title' => ['required',],
            'newspaper_url' => ['required'],
            'image' => ['nullable', 'image'],
        ]);

       
        if($request->hasFile('image')){
            $uploadedFile = $request->file('image');
            Storage::disk('upload')->delete($newspaper->image_url);
            $image_url = $uploadedFile->store('/','upload');
            $request->merge([
                'image_url' => $image_url
            ]);
        }


        $newspaper->update($request->all());
        return redirect()->route('newspapers.index')->with(['success' => 'تم تعديل الجريدة الالكترونية بنجاح']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Newspaper::where('id', '=', $id)->delete();
        return redirect()->route('newspapers.index')->with(['success' => 'تم حذف الجريدة الالكترونية بنجاح']);
    }
}
