<?php

use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use Laravel\Fortify\Features;
use App\Http\Controllers\PostController;

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canRegister' => Features::enabled(Features::registration()),
    ]);
})->name('home');

Route::get('dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');
Route:: resource('posts',PostController::class);
Route:: get('/send/{id}',[PostController::class,'send'])->name('posts.send');
Route::patch('/posts/{post}/verify', [PostController::class, 'verify'])
    ->name('posts.verify');
Route::patch('/posts/{post}/unverify', [PostController::class, 'unverify'])
    ->name('posts.unverify');
require __DIR__.'/settings.php';
