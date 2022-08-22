<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
class Report extends Model
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
        'body',
        'image_url',
    ];
    
    protected $appends =['image_path'];
    protected $hidden = ['image_url'];
    /**
     * Get the user's first name.
     *
     * @param  string  $value
     * @return string
     */
    public function getImagePathAttribute($value)
    {
        if(!$this->image_url){
            return asset('uploads/palceholder.jpg');
        }
        if(stripos($this->image_url , 'http') ===  0){
            return $this->image_url;
        }
        return asset('uploads/' . $this->image_url);
    } 

    protected static function booted()
    {
        static::creating(function(Report $report) {
            $slug = Str::slug($report->title);

            $count = Report::where('slug', 'LIKE', "{$slug}%")->count();
            if ($count) {
                $slug .= '-' . ($count + 1);
            }
            $report->slug = $slug;
        });
    } 
    public function share()
    {
        $this->belongsToMany(Share::class,'shares','share_id','user');
    }


}
