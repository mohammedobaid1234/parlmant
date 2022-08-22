<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Ads;
use App\Models\Newspaper;
use App\Models\Report;
use Illuminate\Http\Request;

class ReportsController extends Controller
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
                    'message' => ' الأخبار'
                ],
                'data' => Report::select(['id', 'title', 'body'])->paginate($request->page_size)
            ],
            200
        );
        // return Report::select(['title','body'])->paginate(3);
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
        $report =  Report::where('id', $id)->first(['id', 'title', 'body']);
        if (!$report) {
            return  response()->json(
                [
                    'status' => [
                        'code' => 404,
                        'status' => false,
                        'message' => 'هذا الخبر غير موجود'
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
                    'message' => 'هذه الخبر موجود'
                ],
                'data' => $report
            ],
            200
        );
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
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        
    }

    public function main()
    {
        $ads = Ads::get();
        $reports = Report::select(['id', 'title', 'body'])->get();
        return  response()->json(
            [
                'status' => [
                    'code' => 200,
                    'status' => true,
                    'message' => ''
                ],
                'data' => [
                    'ads' => $ads,
                    'reports' => $reports
                ]
            ],
            200
        );
    }
}