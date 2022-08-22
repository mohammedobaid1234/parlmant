<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Favorite;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class FavoritesController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:sanctum');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $user = Auth::guard('sanctum')->id();
        $request->validate([
            
            'report_id' => 'required|exists:reports,id',
        ]);
        $favorite = Favorite::where('user_id', $user)
        ->where('report_id', $request->report_id)
        ->first();

        if ($favorite) {
            DB::table('favorites')->where('user_id', $user)
                ->where('report_id', $request->report_id)->delete();

            $favorite->update([
                'favorites' => $favorite->favorites - 1
            ]);
            return  response()->json([
                'status' => [
                    'code' => 201,
                    'status' => false,
                    'message' => 'تم ازالةالعنصر المفضلة'
                ],
                'data' => null
            ],
             201); 
        }else{
            $request->merge([
                'user_id' => $user
            ]);

            $favorite_report = Favorite::create($request->all());
            return  response()->json([
                'status' => [
                    'code' => 201,
                    'status' => true,
                    'message' => 'تم اضافة العنصر الى المفضلة'
                ],
                'data' => $favorite_report
            ],
             201); 
        }
        
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function favorites()
    {
        $user = Auth::guard('sanctum')->user();
     
        
        if(!$user){
            return  response()->json([
                'status' => [
                    'code' => 404,
                    'status' => true,
                    'message' => 'هذا العضو غير موجود'
                ],
                'data' => null
            ],
             404);
        }

        $favorite_report = $user;

        return  response()->json([
            'status' => [
                'code' => 200,
                'status' => true,
                'message' => 'عرض التقارير المفضلة'
            ],
            'data' => $favorite_report->reports
        ],
         200);

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
