<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Questionnaire extends Model
{
    use HasFactory;
    protected $fillable = ['title','description'];
    public function questions()
    {
        # code...
        return $this->hasMany(Question::class);
    }
    public function responses()
    {
        # code...
        return $this->hasManyThrough(Response::class, Question::class);
    }
}