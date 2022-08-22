<?php

namespace App\Http\Controllers;

use App\Models\ChMessages;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ChatMessageController extends Controller
{
    public $array;
    public $users;
    public function __construct()
    {
        $this->array = [];
        $this->users = collect([]);
        return $this->middleware('auth:sanctum');
    }
    public function index()
  {
    $array = ChMessages::where('to_id', Auth::id())
    ->orWhere('from_id', Auth::id())
    ->distinct()->get(['from_id', 'to_id']);
    // return Auth::user();
    // return $array;
    foreach($array as $user){
      if($user->from_id == Auth::id()){

          $this->array[] = $user->to_id;
      }else{
        $this->array[] = $user->from_id;
      }
    }
    // return $this->array;
    $array = array_unique($this->array);
    foreach($array as $key=>$value){
      $user = User::find($value);
      $this->users->push([
        'user' => $user,
        'unreadMessagesNumber' => ChMessages::unread($user->id),
        'last_message' => ChMessages::lastMessage($user->id)
      ]);
    }
    // return $this->users;
    // $users = ChMessage::where('to_id', Auth::id())->distinct()->get(['from_id']);
    // $users = $users->load('users_from');
    // return $users;
    return response()->json([
      'status' => [
        'code' => 200,
        'status' => true,
        'message' => 'users chat'
    ],
    'data' => $this->users
  ], 200);
  }
    public function store(Request $request)
  {
    $request->validate([
        'messageTo' => 'required|exists:users,id',
        'body' => 'nullable',
        'attachment' =>  'nullable'
    ]);

    $id = $request->messageTo;
    $auth_number = Auth::guard('sanctum')->id();
    if ($auth_number <= $id) {
      $chat_number = $auth_number . '.' . $id;
    } else {
      $chat_number = $id . '.' . $auth_number;
    }
    if ($request->hasFile('image')) {
      $uploadedFile = $request->file('image');
      $attachment = $uploadedFile->store('/', 'upload');
      $request->merge([
          'attachment' => $attachment
      ]);
  }
  // return $request;
  
    $msg = ChMessages::create([
      
      'from_id' => Auth::guard('sanctum')->id(),
      'to_id' => $id,
      'body' => $request->message,
      'chat_number' => $chat_number,
      'type' => 'user',
      'attachment'=> $request->attachment
    ])->save();
    
    return response()->json([
      'status' => [
        'code' => 201,
        'status' => true,
        'message' => 'insert new message'
    ],
    'data' => 'data is send'
    ],201);
  }
  
  public function show($id)
  {
      $array = ChMessages::where('to_id', Auth::id())
      ->orWhere('from_id', Auth::id())
      ->distinct()->get(['from_id', 'to_id']);
      
      // $unread = ChMessage::where
      foreach($array as $user){
          if($user->from_id == Auth::guard('sanctum')->id()){
              
              $this->array[] = $user->to_id;
            }else{
                $this->array[] = $user->from_id;
      }
    }
    // return $this->array;
    $array = array_unique($this->array);
    foreach($array as $key=>$value){
        $user = User::find($value);
        $this->users->push($user);
    }
    
    $auth_number = Auth::id();
    if ($auth_number <= $id) {
        $chat_number = $auth_number . '.' . $id;
    } else {
        $chat_number = $id . '.' . $auth_number;
    }
    // dd($chat_number);x
    $prevMessages = ChMessages::with(['to_user:id,name','from_user:id,name'])->where('chat_number', $chat_number)
    ->orderBy('created_at')
    ->get();
    // return $prevMessages;
    // dd($prevMessages);
    // return view('message', [
    //     'user' => User::findOrFail($id),
    //     'messages' => $prevMessages,
    //   'users' => $this->users,
    //   'chat_number' => $chat_number
    // ]);
    $user = User::findOrFail($id);
    return response()->json([
      'status' => [
          'code' => 200,
          'status' => true,
          'message' => 'chat between users'
      ],
      'data' => [
           'previous_messages' =>  $prevMessages,
          //  'user' => $user
      ]
    ]);

    
}
public function makeRead($id)
  {

    $auth_number = Auth::guard('sanctum')->id();
    if ($auth_number <= $id) {
      $chat_number = $auth_number . '.' . $id;
    } else {
      $chat_number = $id . '.' . $auth_number;
    }
    // return $auth_number; 
    $chats = ChMessages::where('chat_number' , $chat_number)
    ->where('from_id',$id)
    ->where('seen', '0')
    ->get();
    // return $chats;
    // return $chats;
    foreach($chats as $chat){
      // return $chat;
      $chat->update(['seen' => '1']);
    }
    return response()->json([
      'status' => [
        'code' => 200,
        'status' => true,
        'message' => 'make messages as read'
    ],
    'data' => ''
  ],200);
  }

  public function destroy($id)
  {
    $auth_number = Auth::guard('sanctum')->id();
    if ($auth_number <= $id) {
      $chat_number = $auth_number . '.' . $id;
    } else {
      $chat_number = $id . '.' . $auth_number;
    }
    // return $chat_number; 
    $chats = ChMessages::where('chat_number' , $chat_number)
    ->delete();

    // foreach($chats as $chat){
    //   ChMessages::delete($chat);
    // }
      return response()->json([
        'status' => [
          'code' => 200,
          'status' => true,
          'message' => 'chat was deleted'
      ],
      'data' => ''
    ],200);
    
    }
  }
