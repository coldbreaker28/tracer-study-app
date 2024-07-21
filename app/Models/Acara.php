<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Acara extends Model
{
    use HasFactory;
    protected $table = 'acaras';
    protected $primaryKey = 'id';
    protected $fillable = [
        'judul',
        'description',
        'poster',
        'jenis',
    ];
    public function users()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}