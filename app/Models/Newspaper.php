<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Newspaper extends Model
{
    use HasFactory;
    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'title', 
        'slug',
        'newspaper_url',
        'image_url',
    ];
    protected $hidden = ['image_url', 'created_at', 'updated_at', 'slug'];
    protected $appends = ['image_path'];
    protected static function booted()
    {
        static::creating(function(Newspaper $newspaper) {
            $slug = Str::slug($newspaper->title);

            $count = Newspaper::where('slug', 'LIKE', "{$slug}%")->count();
            if ($count) {
                $slug .= '-' . ($count + 1);
            }
            $newspaper->slug = $slug;
        });
    }
    public function getImagePathAttribute($value)
    {
      
        if(!$this->image_url){
            // return asset('images/placeholder.png');
        }
        if(stripos($this->image_url , 'http') ===  0){
            return $this->image_url;
        }
        return asset('uploads/' . $this->image_url);
    } 

}
