<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Article;
use Illuminate\Http\Request;

class ArticlesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        
        return  response()->json([
            'status' => [
                'code' => 200,
                'status' => true,
                'message' => ' مقالات'
            ],
            'data' => Article::paginate($request->page_size)
        ],
         200); 
        

        return  response()->json(
            [
                'status' => [
                    'code' => 200,
                    'status' => true,
                    'message' => ' مقالات'
                ],
                'data' => Article::paginate($request->page_size)
            ],
            200
        );
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $article =  Article::where('id', $id)->first(['id', 'title', 'article_url', 'image_url',]);
        if (!$article) {
            return  response()->json(
                [
                    'status' => [
                        'code' => 404,
                        'status' => false,
                        'message' => 'هذا المقال غير موجود'
                    ],
                    'data' => null
                ],
                404
            );
        }
        return  response()->json(
            [
                'status' => [
                    'code' => 200,
                    'status' => true,
                    'message' => 'هذا المقال موجود'
                ],
                'data' => $article
            ],
            200
        );
    }

    public function articleToday()
    {
        return  response()->json(
            [
                'status' => [
                    'code' => 200,
                    'status' => true,
                    'message' => ' مقال اليوم'
                ],
                'data' => Article::latest()->first()
            ],
            404
        );
        // return Article::latest()->first();
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}