<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
use Illuminate\Support\Str;

class Siswa extends Model
{
    protected $table = 'siswas';
    protected $primaryKey = 'id';
    protected $dates = ['tanggal_lulus', 'tanggal_lahir'];
    protected $fillable = [
        'slug',
        'user_id',
        'jurusan_id',
        'name',
        'tanggal_lahir',
        'alamat',
        'nama_orang_tua',
        'nis',
        'nisn',
        'status_siswa',
        'tanggal_lulus',
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

    public function karirs()
    {
        return $this->hasMany(Karir::class, 'siswa_id');
    }
    public function users()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
    public function jurusans()
    {
        # code...
        return $this->belongsTo(Jurusan::class, 'jurusan_id');
    }
    public function getTanggalLulusAttribute($value)
    {
        return Carbon::parse($value)->format('d-m-Y');
    }
    public function getTanggalLahirAttribute($value)
    {
        return Carbon::parse($value)->format('d-m-Y');
    }
    public function checkNISNISN($nisn, $nis)
    {
        # code...
        return self::where('nis', $nis)->where('nisn', $nisn)->first();
    }
}