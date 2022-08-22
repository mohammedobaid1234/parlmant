<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Pivot;

class Favorite extends Pivot
{
    use HasFactory;
    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'user_id',
        'report_id'  
    ];
    protected $table = 'favorites';

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function user()
    {
        $this->belongsToMany(User::class,'favorites','user_id');
    }
    public function report()
    {
        $this->belongsToMany(Report::class,'favorites','report_id','user');
    }
}
