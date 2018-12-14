<?php

namespace App\Http\Controllers\Admin;

use App\Post;
use App\Photo;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PhotosController extends Controller
{
    public function store(Post $post) {
        $this->validate(request(), [
            'photo' => 'required|image|max:2048'
        ]);
       $photo = request()->file('photo')->store('public');
    
       //crea un link simbolico entre public y storage
       //php artisan storage:link
       Photo::create([
           'url' => Storage::url($photo),
           'post_id'=> $post->id
       ]);
    }
}
