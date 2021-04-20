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

//admin (el "as" es el name)
Route::group(['prefix' => 'admin', 'as' => 'admin.', 'middleware' => ['auth', 'permission:admin']], function () {
    Route::get('/', [\App\Http\Controllers\AdminController::class, 'index'])->name("index");
    Route::prefix('/user')->name('user.')->group(function () {
        Route::get('/search/{email}/{role?}', [\App\Http\Controllers\AdminController::class, 'userSearch'])->name("search");
        Route::get('/info/{user}', [\App\Http\Controllers\AdminController::class, 'userInfo'])->name("info");
        Route::get('/edit/{user}', [\App\Http\Controllers\AdminController::class, 'userEdit'])->name("edit");
        Route::put('/update/{user}', [\App\Http\Controllers\AdminController::class, 'userUpdate'])->name("update");
        Route::delete('/delete/{user}/{back?}', [\App\Http\Controllers\UserController::class, 'destroy'])->name('destroy');
    });
    Route::delete('/video/{video}/{back?}', [\App\Http\Controllers\VideoController::class, 'destroy'])->name('video.destroy');
});

//editor
Route::group(['prefix' => 'editor', 'middleware' => ['auth', 'permission:editor|admin']], function () {
    Route::resource('video', \App\Http\Controllers\VideoController::class);
});

//common
Route::group(['middleware' => ['auth', 'permission:admin|editor|visitor']], function () {
    Route::prefix('/settings')->name('settings.')->group(function () {
        Route::get('/', [\App\Http\Controllers\UserController::class, 'profile'])->name('profile');
        Route::post('/update', [\App\Http\Controllers\UserController::class, 'updateProfile'])->name('updateProfile');
        Route::post('/update/password', [\App\Http\Controllers\UserController::class, 'updatePassword'])->name('updatePassword');
        Route::delete('/delete/{user}', [\App\Http\Controllers\UserController::class, 'destroy'])->name('user.destroy');
    });
    Route::prefix('/video')->name('video.')->group(function () {
        //Videos
        Route::get('/', [\App\Http\Controllers\VideoController::class, 'index'])->name("index");
        Route::get('/{video}', [\App\Http\Controllers\VideoController::class, 'show'])->name('show');
        Route::get('/search/{video}', [\App\Http\Controllers\VideoController::class, 'search'])->name('search');
        Route::get('/watch/{video}', [\App\Http\Controllers\VideoController::class, 'watch'])->name('watch');
        //Score
        Route::delete('/delete/score/{score}', [\App\Http\Controllers\ScoreController::class, 'destroy'])->name('destroy.score');
        Route::put('/update/score/{score}', [\App\Http\Controllers\ScoreController::class, 'update'])->name('update.score');
        Route::post('/insert/score', [\App\Http\Controllers\ScoreController::class, 'store'])->name('score.store');
    });
});
