<?php

namespace App\Http\Controllers\Admin;

use App\Post;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Category;
use App\Tag;
use Carbon\Carbon;

class PostsController extends Controller
{
    public function index() {
      $posts = Post::all();
      return view('admin.posts.index', compact('posts'));
    }
//    public function create() {
//      $categories = Category::all();
//      $tags = Tag::all();
//
//      return view('admin.posts.create', compact('categories', 'tags'));
//    }
//    public function store(Request $request) {
//      // validacion
//    //   return Post::create($request->all());
//      $this->validate($request, [
//        'title' => 'required',
//        'body' => 'required',
//        'category' => 'required',
//        'tags' => 'required',
//        'excerpt' => 'required'
//      ]);
//      $post = new Post;
//      $post->title = $request->get('title');
//      $post->url = $request->get('title');
//
//      $post->body = $request->get('body');
//      $post->excerpt = str_slug($request->get('excerpt'));
//      $post->published_at = $request->get('published_at') != null ? Carbon::parse($request->get('published_at')) : null;
//      $post->category_id = $request->get('category');
//      $post->save();
//      $post->tags()->attach($request->get('tags'));
//      return back()->with('flash', 'Tu publicación ha sido creada');
//
//
//  //  return $request->all();
//    }
    public function store(Request $request) {
        $this->validate($request, ['title' => 'required']);
        $post = Post::create([
            'title' => $request->get('title'),
            'url' => str_slug($request->get('title'))
        ]);
        return redirect()->route('admin.posts.edit', $post);
    }
    
    public function edit(Post $post) {
        $categories = Category::all();
        $tags = Tag::all();
        return view('admin.posts.edit', compact('categories','tags', 'post'));
    }
    
    public function update(Post $post, Request $request) {
      // validacion
      $this->validate($request, [
        'title' => 'required',
        'body' => 'required',
        'category' => 'required',
        'tags' => 'required',
        'excerpt' => 'required'
      ]);
      $post->title = $request->get('title');
      $post->url = $request->get('title');

      $post->body = $request->get('body');
      $post->excerpt = str_slug($request->get('excerpt'));
      $post->published_at = $request->get('published_at') != null ? Carbon::parse($request->get('published_at')) : null;
      $post->category_id = $request->get('category');
      $post->save();
      
      // $post->tags()->attach($request->get('tags')); //esto duplicaria en la tabla asociativa
      $post->tags()->sync($request->get('tags'));
      // return back()->with('flash', 'Tu publicación ha sido guardada');
      return redirect()->route('admin.posts.edit', $post)->with('flash', 'Tu publicación ha sido guardada');

  //  return $request->all();
    }
}
