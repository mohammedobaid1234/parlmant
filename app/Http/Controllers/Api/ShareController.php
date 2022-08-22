<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Share;
use GuzzleHttp\Psr7\Uri;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ShareController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth:sanctum');
        
    }

    public function store(Request $request)
    {
        $request->validate([
            'report_id' => 'required|exists:reports,id',
        ]);
        $share = Share::where('user_id', Auth::guard('sanctum')->id())
        ->where('report_id', $request->report_id)
        ->first();
        if ($share) {
            
            return  response()->json([
                'status' => [
                    'code' => 201,
                    'status' => false,
                    'message' => 'العنصر تم مشاركته مسباقا'
                ],
                'data' => null
            ],
             201); 
        }else{
            $url = 'http://localhost:8000/api/reports/' . $request->report_id;
            $request->merge([
                'report_url' => $url,
                'user_id' => Auth::guard('sanctum')->id(),
            ]);
            
            
            $share_report = Share::create($request->all());
            return  response()->json([
                'status' => [
                    'code' => 201,
                    'status' => true,
                    'message' => 'تم مشاركة العنصر'
                ],
                'data' => $share_report
            ],
             201); 
        }
    }
    public function destroy($id)
    {
        
        $share = Share::where('user_id', Auth::guard('sanctum')->id())
        ->where('report_id', $id)
        ->delete();

        return  response()->json([
            'status' => [
                'code' => 201,
                'status' => true,
                'message' => 'تم حذف العنصر'
            ],
            'data' => ''
        ],
         201);

    }
}
