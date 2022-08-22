<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Article;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ArticlesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $articles = Article::orderBy('created_at','desc')->paginate(10);;
        return view('admin.article.index' ,[
            'articles' => $articles,
            'title' => 'قسم المقالات'
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.article.create', [
            'title' => "اضافة مقال جديد"
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
            'article_url' => ['required'],
            'image' => ['required', 'image'],
        ]);
        if($request->hasFile('image')){
            $uploadedFile = $request->file('image');
            $image_url = $uploadedFile->store('/','upload');
            $request->merge([
                'image_url' => $image_url
            ]);
        }
        Article::create($request->all());
        return redirect()->route('articles.index')->with(['success' => 'تم اضافة المقال بنجاح']);
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
        $article = Article::findOrFail($id);
        return view('admin.article.edit',[
            'article' => $article,
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
        $article = Article::findOrFail($id);

        $request->validate([
            'title' => ['required'],
            'article_url' => ['required'],
            'image' => ['nullable', 'image'],
        ]);

       
        if($request->hasFile('image')){
            $uploadedFile = $request->file('image');
            Storage::disk('upload')->delete($article->image_url);
            $image_url = $uploadedFile->store('/','upload');
            $request->merge([
                'image_url' => $image_url
            ]);
        }

        $article->update($request->all());
        return redirect()->route('articles.index')->with(['success' => 'تم تعديل المقال بنجاح']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Article::where('id', '=', $id)->delete();
        return redirect()->route('articles.index')->with(['success' => 'تم حذف المقال بنجاح']);
    }
}
