<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Str;
class Tweet extends Model
{
    use HasFactory;
    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'body',
        'comments',
        'slug',
        'image_url',
        'likes',
        'user_id',
    ];
    protected $appends =['image_path','time'];
    protected $hidden = ['image_url'];
    public $with = ['tweetComments'];
    protected static function booted()
    {
        static::creating(function(Tweet $tweet) {
            

            $slug = Str::slug($tweet->body);

            $count = Tweet::where('slug', 'LIKE', "{$slug}%")->count();
            if ($count) {
                $slug .= '-' . ($count + 1);
            }
            $tweet->slug = $slug;
        });

        static::updating(function (Tweet $tweet) {
            $slug = Str::slug($tweet->body);

            $count = Tweet::where('slug', 'LIKE', "{$slug}%")->count();
            if ($count) {
                $slug .= '-' . ($count + 1);
            }
            $tweet->slug = $slug;
        });
    }
    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function tweetComments()
    {
        return $this->hasMany(Comment::class, 'tweet_id', 'id');
    }
    public function likes()
    {
        return $this->hasMany(Like::class);
    }
    public function getImagePathAttribute($value)
    {
        if(!$this->image_url){
            return asset('images/placeholder.png');
        }
        if(stripos($this->image_url , 'http') ===  0){
            return $this->image_url;
        }
        return asset('uploads/' . $this->image_url);
    }
    public function getTimeAttribute($value)
    {
        return $this->created_at->diffForHumans();
    }
   
}
