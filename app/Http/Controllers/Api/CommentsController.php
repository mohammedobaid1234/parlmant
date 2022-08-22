<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Comment;
use App\Models\Tweet;
use App\Models\User;
use App\Notifications\CommentCreatedNotification;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Request as FacadesRequest;

class CommentsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:sanctum')->except(['show', 'index']);
    }

    public function store(Request $request)
    {
        $request->validate([
            'body' => 'required',
            'tweet_id' => 'required|exists:tweets,id'
        ]);
        $request->merge(['user_id' => Auth::guard('sanctum')->id()]);
        $user = Auth::guard('sanctum')->user();
        // return $user;
        if ($user->type == '1') {
            return  response()->json(
                [
                    'status' => [
                        'code' => 403,
                        'status' => false,
                        'message' => 'هذه العملية غير مسموحة'
                    ],
                    'data' => null
                ],
                403
            );
        }  
        if ($request->hasFile('image')) {
            $uploadedFile = $request->file('image');
            
            $image_url = $uploadedFile->store('/', 'upload');
            $request->merge([
                'image_url' => $image_url
            ]);
        }
        // return $request;
        $comment = Comment::create($request->all());
        $tweet = Tweet::where('id', $request->tweet_id)->first();
        if(!$tweet){
            return  response()->json([
                'status' => [
                    'code' => 404,
                    'status' => true,
                    'message' => 'هذا التغريدة غير موجود'
                ],
                'data' => null
            ],
             404);
        }
        if(!$tweet) {
            return  response()->json([
                'status' => [
                    'code' => 404,
                    'status' => true,
                    'message' => 'هذه التغريدة غير موجودة'
                ],
                'data' => null
            ],
             404);
        }
        $tweet->update([
            'comments' => $tweet->comments + 1
        ]);
        $user = $tweet->load('user');
        
        $user = User::findOrFail($user->user->id);
       
        $user->notify(new CommentCreatedNotification($comment));

        return  response()->json([
            'status' => [
                'code' => 201,
                'status' => true,
                'message' => 'تم انشاء تعليق'
            ],
            'data' => $comment->load('user')
        ],
         201); 
         
         
    }
    
}
