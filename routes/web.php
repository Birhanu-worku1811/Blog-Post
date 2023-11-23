<?php

use App\Http\Controllers\AboutController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PostsController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', [HomeController::class, 'home'])->name('home.index') //->middleware('auth')
;

Route::get('/home', [HomeController::class, 'home'])->name('home.index')//    ->middleware('auth')
;

Route::get('/contact', [HomeController::class, 'contact'])->name('home.contact');
Route::get('/secret', 'App\Http\Controllers\HomeController@secret')
    ->name('secret')
    ->middleware('can:home.secret');

Route::get('single', AboutController::class);

$posts = [
    1 => [
        'title' => 'Intro to Laravel',
        'content' => 'This is a short intro to Laravel',
        'is_new' => true
    ],
    2 => [
        'title' => 'Intro to PHP',
        'content' => 'This is a short intro to PHP',
        'is_new' => false
    ]
];

Route::resource('posts', PostsController::class);

//
//Route::get('/posts', function () use ($posts) {
////    dd(request()->all());
//    dd(request()->input('page', 1));
////    compact($posts) === ['posts' => $posts];
//
//    return view('posts.index', ['posts' => $posts]);
//});
//
////Route::get('/contact', function () {
////    return view('home.contact');
////})->name('home.contact');
//
//Route::get('/posts/{id}', function ($id) use ($posts) {
//    abort_if(!isset($posts[$id]), 404);
//    return view('posts.show', ['post' => $posts[$id]]);
//})->name('posts.show');
//
//Route::get('recent-posts/{days_ago?}', function ($daysAgo = 20) {
//    return "posts from ".$daysAgo." days ago";
//})->name('posts.recent.index')->middleware('auth');

Route::prefix('/fun')->name('fun.')->group(function () use ($posts) {

    Route::get('responses', function () use ($posts) {
        return response($posts, 201)->header('Content-Type', 'application/json')->cookie('MY_COOKIE', 'BIRHANU', 3600);
    })->name('responses');

    Route::get('redirect', function () {
        return redirect('/contact');
    })->name('redirect');

    Route::get('back', function () {
        return back();
    })->name('back');

    Route::get('named-route', function () {
        return redirect()->route('posts.show', ['id' => 1]);
    })->name('named-route');

    Route::get('away', function () {
        return redirect()->away('https://google.com');
    })->name('away');

    Route::get('json', function () use ($posts) {
        return response()->json($posts);
    })->name('json');

    Route::get('download', function () use ($posts) {
        return response()->download(public_path('/love.jpg'),
            'love.jpg');
    })->name('download');
});

Route::get('/posts/tag/{tag}', 'App\Http\Controllers\PostTagController@index')->name('posts.tags.index');
Route::resource('posts.comments', 'App\Http\Controllers\PostCommentController')->only('index', 'store');
Route::resource('users.comments', 'App\Http\Controllers\UserCommentController')->only(['store']);
Route::resource('users', 'App\Http\Controllers\UserController')->only('show', 'edit', 'update');

Route::get('mailable', function () {
    $comment = App\Models\Comment::find(1);
    return new App\Mail\CommentPostedMarkdown($comment);
});
Auth::routes();

