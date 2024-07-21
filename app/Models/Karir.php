<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Karir extends Model
{
    use HasFactory;
    protected $table = 'karirs';
    protected $primaryKey = 'id';
    protected $fillable = [
        'slug',
        'siswa_id',
        'email',
        'profesi',
        'bidang',
        'jenis_karir',
        'nama_tempat',
        'alamat_karir',
        'foto_tempat',
        'no_telp',
        'pendapatan',
        'tempat_tinggal',
    ];

    public function siswa()
    {
        return $this->belongsTo(Siswa::class, 'id');
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
