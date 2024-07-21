<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Support\Str;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $table = 'users';
    protected $primaryKey = 'id';
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'slug',
        'name',
        'email',
        'password',
        'level',
        'avatar',
    ];

    protected static function boot()
    {
        # code...
        parent::boot();

        // static::creating(function ($model) {
        //     $model->slug = Str::slug($model->name . '-' . Str::random(5));
        // });

        static::creating(function ($model) {
            $model->slug = Str::random(30);
        });
    }

    public function getRouteKeyName()
    {
        return 'slug';
    }

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    public function acaras()
    {
        return $this->hasMany(Acara::class, 'id');
    }
    public function siswas()
    {
        return $this->hasMany(Siswa::class, 'user_id');
    }
    public function gurus()
    {
        # code...
        return $this->hasMany(Guru::class, 'user_id');
    }
}