<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UsersController;
use App\Http\Controllers\UploadController;
use App\Http\Controllers\ImagenesController;
use Illuminate\Support\Facades\Auth;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/' , function () {
    return view('masonry');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::get('/authorization', [App\Http\Controllers\UsersController::class, 'authUsers']);

Route::get('/authForm/{id}', [App\Http\Controllers\UsersController::class, 'authForm'])->name('users.authForm');

Route::put('/saveAuth/{id}', [App\Http\Controllers\UsersController::class, 'saveAuth'])->name('users.saveAuth');

Route::view('/upload','upload');

Route::post('handle', [UploadController::class, 'handle']);

Route::get('moderator', [ImagenesController::class, 'moderator']);

Route::post('allowResponse', [ImagenesController::class, 'allowResponse']);

Route::get('imagenes', [ImagenesController::class, 'index']);

Route::get('allowImages', [ImagenesController::class, 'allowImages']);

Route::get('favCatalog', [ImagenesController::class, 'favCatalog']);

Route::get('favorites', [ImagenesController::class, 'favorites']);

Route::get('favSearch/{id_imagen}', [ImagenesController::class, 'favSearch']);

Route::post('dislikeHandler/{id_imagen}', [ImagenesController::class, 'dislikeHandler']);

Route::post('likeHandler/{id_imagen}', [ImagenesController::class, 'likeHandler']);