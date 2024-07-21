<?php

namespace App\Http\Controllers\components;

use App\Http\Controllers\Controller;
use App\Models\Acara;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;

class GuruController extends Controller
{
    //
    public function home($slug)
    {
        # code...
        $user = User::where('slug', $slug)->firstOrFail();
        $guru = $user->gurus()->first();
        if(!$guru){
            abort(404);
        }
        $post = Acara::with('users')->get()->all();
    }
}