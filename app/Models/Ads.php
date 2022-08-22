<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ads extends Model
{
    use HasFactory;

    protected $fillable = ['image_url', 'type'];
    protected $appends =['image_path',];
    public function getAdsTypeAttribute()
    {
        $type = $this->type;
        if ($type == 1) {
            return 'رخيص';
        }
        if ($type == 2) {
            return 'متوسط';
        }
        return 'غالي';
    }


    public function getImagePathAttribute($value)
    {
        if (!$this->image_url) {
            return asset('uploads/palceholder.jpg');
        }
        if (stripos($this->image_url, 'http') ===  0) {
            return $this->image_url;
        }
        return asset('uploads/' . $this->image_url);
    }
}
