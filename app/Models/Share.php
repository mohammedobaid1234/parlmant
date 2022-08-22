<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Pivot;

class Share extends Pivot
{
    use HasFactory;
    protected $table = 'shares';


    protected $fillable = ['user_id', 'report_id', 'report_url'];
    // public  $with = ['user'];
    public function user()
    {
        $this->belongsToMany(User::class,'shares','user_id');
    }
    public function reports()
    {
        $this->belongsToMany(Report::class,'shares','report_id','user');
    }


}
