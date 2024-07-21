<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Jurusan extends Model
{
    use HasFactory;
    protected $table = 'jurusans';
    protected $primaryKey = 'id';
    protected $fillable = [
        'program_studi',
        'kompetensi_keahlian',
    ];

    public function siswas()
    {
        # code...
        return $this->hasOne(Siswa::class, 'id');
    }
}