<?php

use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use Laravel\Fortify\Features;
use App\Http\Controllers\PostController;
use App\Events\HelloTest;
use App\Models\Post;
use Illuminate\Support\Facades\Mail;
use App\Mail\TestMarkdownNotification;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Notification;

Route::get('/notify', [Notification::class, 'notify']);
//send email
Route::get('/test-mail', function () {
    $user = \App\Models\User::first();
    Mail::to($user->email)->send(new TestMarkdownNotification($user));

    return 'Mail sent! with markdown';
});
Route::get('/magic-login/{user}', function (Request $request, User $user) {

    if (! $request->hasValidSignature()) {
        abort(403, 'Invalid or expired link.');
    }

    Auth::login($user);

    return redirect('/dashboard'); // change to your route
})
->middleware('guest') // optional but recommended
->name('magic.login');
//end mail
Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canRegister' => Features::enabled(Features::registration()),
    ]);
})->name('home');
//===============reverb================//
Route::get('/reverb-test', function () {
    return Inertia::render('Post/ReverbTest');
});
Route::get('/event/{postId}', function ($postId) {
    $post = Post::findOrFail($postId); // fetch the model
    HelloTest::dispatch($post);         // dispatch event

    return response("Event dispatched for post ID: {$post->id}", 200);
});
Route::get('/event', function(){
    $message ="event route is working";
    HelloTest::dispatch($message);
});
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
