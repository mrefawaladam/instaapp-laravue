<?php

use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', function () {
    return Inertia::render('Home');
});
use App\Http\Controllers\AuthController;
use App\Http\Controllers\PostController;

Route::get('/login', [AuthController::class, 'showLoginPage'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::get('/register', [AuthController::class, 'showRegisterPage'])->name('register');
Route::post('/register', [AuthController::class, 'register']);

 Route::middleware(['auth'])->group(function () {
    Route::get('/posts/create', [PostController::class, 'create'])->name('posts.create');
    Route::post('/posts', [PostController::class, 'store'])->name('posts.store');
    Route::get('/feed', [PostController::class, 'index'])->name('feed'); // Feed
    Route::post('/posts/{post}/like', [PostController::class, 'like'])->middleware('auth');
    Route::post('/posts/{post}/comments', [PostController::class, 'addComment']);
    Route::put('/comments/{comment}', [PostController::class, 'updateComment']);
Route::delete('/comments/{comment}', [PostController::class, 'deleteComment']);
});