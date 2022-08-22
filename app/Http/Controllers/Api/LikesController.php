<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Like;
use App\Models\Tweet;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class LikesController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth:sanctum')->except(['show', 'index']);
    }
    
    public function store(Request $request)
    {
        $tweet = Tweet::where('id', $request->tweet_id)->firstOrFail();
        if(!$tweet){
            return  response()->json([
                'status' => [
                    'code' => 404,
                    'status' => true,
                    'message' => 'هذا التغريدة غير موجودة'
                ],
                'data' => null
            ],
             404);
        }
        $request->validate([
            // 'user_id' => 'required|exists:users,id',
            'tweet_id' => 'required|exists:tweets,id',
        ]);
        $request->merge([
            'user_id' => Auth::guard('sanctum')->id()
        ]);
        $like = Like::where('user_id', $request->user_id)
            ->where('tweet_id', $request->tweet_id)
            ->first();
        if ($like) {
            DB::table('likes')->where('user_id', $request->user_id)
                ->where('tweet_id', $request->tweet_id)->delete();

            $tweet->update([
                'likes' => $tweet->likes - 1
            ]);
            return  response()->json([
                'status' => [
                    'code' => 200,
                    'status' => true,
                    'message' => 'تم ازالة الاعجاب عن التغريدة'
                ],
                'data' => null
            ],
             200); 
        } else {
            Like::create($request->all());
            $tweet = Tweet::where('id', $request->tweet_id)->firstOrFail();
            $tweet->update([
                'likes' => $tweet->likes + 1
            ]);
            return  response()->json([
                'status' => [
                    'code' => 201,
                    'status' => true,
                    'message' => 'تم الاعجاب بالتغريدة'
                ],
                'data' => $tweet
            ],
             201); 
        }
    }
}
