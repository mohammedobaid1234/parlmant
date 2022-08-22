<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Newspaper;
use Illuminate\Http\Request;

class NewspapersController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        return  response()->json(
            [
                'status' => [
                    'code' => 200,
                    'status' => true,
                    'message' => ' الجرائد الالكترونية'
                ],
                'data' => Newspaper::paginate($request->page_size)
            ],
            200
        );
        // return Newspaper::paginate(3);


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
        $news =  Newspaper::where('id', $id)->first(['id', 'title', 'newspaper_url']);
        if (!$news) {
            return  response()->json(
                [
                    'status' => [
                        'code' => 404,
                        'status' => false,
                        'message' => 'هذا الجريدة غير موجود'
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
                    'message' => 'هذه الجريدة موجود'
                ],
                'data' => $news
            ],
            200
        );
        // return $news;

    }

    public function newspaperToday()
    {
        return  response()->json(
            [
                'status' => [
                    'code' => 200,
                    'status' => true,
                    'message' => ' جريدة اليوم'
                ],
                'data' => Newspaper::latest()->first()
            ],
            404
        );
        // return Newspaper::latest()->first();
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