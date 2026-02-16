<?php

use App\Http\Controllers\PostController;
use Illuminate\Support\Facades\Route;

Route::view('/', 'home');

Route::controller(PostController::class)->group(function () {
    Route::get('/posts', 'index')->name('posts.index');
    Route::get('/posts/add', 'add');
    Route::post('/posts', 'store');
    Route::get('/posts/{post:slug}', 'show');

    Route::get('/posts/{post:slug}/edit', 'edit');
    Route::patch('/posts/{post:slug}', 'update');
    Route::patch('/posts/{post:slug}/status', 'status')->name('posts.status');
    Route::delete('/posts/{post:slug}', 'destroy')->name('posts.destroy');
});
