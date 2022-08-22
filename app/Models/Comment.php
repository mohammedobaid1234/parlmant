<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Comment extends Model
{
    use HasFactory;
    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'body',
        'slug',
        'image_url',
        'user_id',
        'tweet_id'
    ];
    protected $appends =['time'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    protected static function booted()
    {
        static::creating(function(Comment $comment) {
            $slug = Str::slug($comment->body);

            $count = Comment::where('slug', 'LIKE', "{$slug}%")->count();
            if ($count) {
                $slug .= '-' . ($count + 2);
            }
            $comment->slug = $slug;
        });
    }
    
    public function getTimeAttribute($value)
    {
        return $this->created_at->diffForHumans();
    }
}
