<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class ChMessages extends Model
{
    use HasFactory;

    protected $fillable = [
        'from_id',
        'to_id',
        'body',
        'chat_number',
        'type',
        'seen',
        'attachment'
    ];
    protected $appends =['attachment_path'];
    protected $hidden = ['attachment'];

    public function to_user()
    {
        return $this->belongsTo(User::class, 'to_id');
    }
    public function users()
    {
        return $this->belongsTo(User::class, 'id');
    }
    public function from_user()
    {
        return $this->belongsTo(User::class, 'from_id');
    }
    public static function unread($id)
    {
        // if()
        $auth_number = Auth::guard('sanctum')->id();
        if ($auth_number <= $id) {
        $chat_number = $auth_number . '.' . $id;
        } else {
        $chat_number = $id . '.' . $auth_number;
        }
      
        $unread = ChMessages::where('chat_number', $chat_number )
        ->where('from_id',$id)
        ->where('seen' , '0')
        ->count();
        return $unread;
    }
    public static function lastMessage($id){
        $auth_number = Auth::guard('sanctum')->id();
        if ($auth_number <= $id) {
        $chat_number = $auth_number . '.' . $id;
        } else {
        $chat_number = $id . '.' . $auth_number;
        }
        $last = ChMessages::where('chat_number', $chat_number )
        // ->where('to_id',$id)
        ->orderBy('created_at', 'DESC')
        ->first();
        return $last;
    }
    public function getAttachmentPathAttribute($value)
    {
        if($this->attachment == null){
            return null;
        }
        return asset('uploads/' . $this->attachment);
    }

}
