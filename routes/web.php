<?php

use Illuminate\Support\Facades\Route;
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

Auth::routes();

Route::get('/', [App\Http\Controllers\IndexController::class, 'index'])->name('index');

//admin
Route::group(['prefix'=>'admin', 'middleware' =>['auth', 'permission:admin']], function(){
    Route::resource('users',\App\Http\Controllers\UserController::class);
});

//editor
Route::group(['prefix'=>'editor', 'middleware' =>['auth', 'permission:editor|admin']], function(){
    Route::resource('videos',\App\Http\Controllers\VideoController::class);
});

//common
Route::group(['middleware' => ['auth', 'permission:admin|editor|visitor']], function(){
    Route::prefix('/settings')->name('settings.')->group(function(){
        Route::get('/',[\App\Http\Controllers\UserController::class,'profile'])->name('profile');
        Route::post('update',[\App\Http\Controllers\UserController::class, 'updateProfile'])->name('updateProfile');
        Route::post('update/password',[\App\Http\Controllers\UserController::class, 'updatePassword'])->name('updatePassword');
    });
    Route::prefix('/video')->name('video.')->group(function(){
        //Videos
        Route::get('/',[\App\Http\Controllers\VideoController::class,'index'])->name("index");
        Route::get('/{video}',[\App\Http\Controllers\VideoController::class,'show'])->name('show');
        Route::get('/watch/{video}',[\App\Http\Controllers\VideoController::class,'watch'])->name('watch');
        //Score
        // --- No le pongo delete, por que voy a poner null el campo cont, para que siga la puntuación
        Route::get('/delete/comment/{score}',[\App\Http\Controllers\ScoreController::class,'deleteComment'])->name('deleteComment');
        Route::post('/insert/score',[\App\Http\Controllers\ScoreController::class,'store'])->name('score.store');
    });
});

