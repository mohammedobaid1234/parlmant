<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Support\Str;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'name',
        'slug',
        'phone_number',
        'phone_number_verified_at',
        'about',
        'full_name',
        'birthday',
        'marital_status',
        'type',
        'email',
        'password',
        'image_url',
        'council_id',
        'code'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
        'image_url',
        'created_at',
        'updated_at',
        'code'
        
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
    protected $appends = ['image_path', 'council_name'];

    /**
     * The reflations.
     *
     * @var void
     */
    public function council()
    {
        return $this->belongsTo(Council::class);
    }
    public function tweets()
    {
        return $this->hasMany(Tweet::class);
    }
    public function comments()
    {
        return $this->hasMany(Comment::class);
    }
    public function likes()
    {
        return $this->hasMany(Like::class);
    }
    public function favorites()
    {
        return $this->hasMany(Favorite::class);
    }
    
    public function shares()
    {
      return $this->hasMany(Share::class);
    }

    public function reports()
    {
        
        return $this->belongsToMany(Report::class, 'favorites');
    }
    protected static function booted()
    {
        static::creating(function (User $user) {
            $slug = Str::slug($user->name);

            $count = User::where('slug', 'LIKE', "{$slug}%")->count();
            if ($count) {
                $slug .= '-' . ($count + 1);
            }
            $user->slug = $slug;
        });
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
    public function getCouncilNameAttribute($id)
    {
        if ($this->type == 2) {
            if ($this->council->parent == null) {
                return $this->council->name;
            } else {
                return $this->council->parent->name;
            }
        }
    }

    public function getUserTypeAttribute()
    {
        $type = $this->type;
        if ($type == 1) {
            return 'عضو فعال';
        }
        if ($type == 2) {
            return 'عضو مجلس';
        }
        return 'أدمن';
    }

    public function deviceTokens()
    {
        return $this->hasMany(DeviceToken::class);
    }

    public function routeNotificationForFcm()
    {
        return $this->deviceTokens()->pluck('token')->toArray();
    }
    
}
