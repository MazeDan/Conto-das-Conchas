<?php

namespace App\Http\Controllers;
use App\Models\Post;

abstract class Controller
{
public function index()
{
    $posts = Post::where('published', true)
                 ->latest()
                 ->get();

    return view('posts.index', compact('posts'));
}

public function show($slug)
{
    $post = Post::where('slug', $slug)
                ->where('published', true)
                ->firstOrFail();

    return view('posts.show', compact('post'));
}
}