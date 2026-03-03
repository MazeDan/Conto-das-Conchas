<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PostController;
use App\Models\Post;

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});



Route::get('/', function () {
    $posts = Post::where('published', true)
        ->latest()
        ->get();

    return view('posts.index', compact('posts'));
});

Route::get('/post/{slug}', function ($slug) {
    $post = Post::where('slug', $slug)
        ->where('published', true)
        ->firstOrFail();

    return view('posts.show', compact('post'));
});

require __DIR__.'/auth.php';
