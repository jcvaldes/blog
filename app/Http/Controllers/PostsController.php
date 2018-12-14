<?php

namespace App\Http\Controllers;

use App\Post;
use Illuminate\Http\Request;

class PostsController extends Controller
{
    public function show(Post $post)
    {
//        $post = Post::find($id);
//        return view('posts.show', compact('post'));
        return view('posts.show', compact('post'));
    }
}
