<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Like extends Model
{
    use HasFactory;
    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'user_id',
        'tweet_id',  
    ];
    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function tweet()
    {
        return $this->belongsTo(Tweet::class);
    }
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
