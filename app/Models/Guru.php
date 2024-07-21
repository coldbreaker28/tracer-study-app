<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Guru extends Model
{
    use HasFactory;
    // 
    protected $table = 'gurus';
    protected $primaryKey = 'id';
    protected $fillable = [
        'slug',
        'user_id',
        'name',
        'jabatan',
        'alamat_guru',
        'email',
    ];
    
    public function users()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
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

}