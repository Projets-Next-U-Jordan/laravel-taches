<?php

use App\Http\Controllers\AjaxController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\TaskController;
use Illuminate\Support\Facades\Auth;
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

Route::group(['middleware' => ['auth']], function () {
    Route::get('/', [HomeController::class, 'index'])->name("home.index");
    Route::get('/tasks', [TaskController::class, 'index'])->name("task.index");

    Route::prefix('/ajax')->name('ajax.')->controller(AjaxController::class)->group(function () {
        Route::prefix('/tasks')->name('tasks.')->group(function () {
            Route::get('/', 'fetchTasks')->name('fetch');
            Route::post('/', 'createTask')->name('create');
            Route::put('/', 'updateTask')->name('update');
            Route::patch('/', 'updateTask')->name('update');
            Route::delete('/', 'deleteTask')->name('delete');
        });
    });

    Route::prefix("/tasks")->name("task.")->controller(TaskController::class)->group(function () {
        Route::get('/', 'index')->name("index");
        Route::get('/calendar', 'calendar')->name("calendar");
        Route::get('/json', 'fetch')->name("fetch");
        Route::get('/new', 'create')->name("new");
        Route::post('/new', 'storeEdit')->name("store");
        Route::get('/{task}', 'show')->name("show");
        Route::get('/{task}/edit', 'edit')->name("edit");
        Route::put('/{task}/edit', 'storeEdit')->name("update");
        Route::delete('/{task}/delete', 'destroy')->name("destroy");
    });

    Route::prefix("/categories")->name("category.")->controller(CategoryController::class)->group(function () {
        Route::get('/', 'index')->name("index");
        Route::get('/new', 'create')->name("new");
        Route::post('/new', 'storeEdit')->name("store");
        Route::get('/{category}', 'show')->name("show");
        Route::get('/{category}/edit', 'edit')->name("edit");
        Route::put('/{category}/edit', 'storeEdit')->name("update");
        Route::delete('/{category}/delete', 'destroy')->name("destroy");
    });

});

Route::post('/logout', function () {
    Auth::logout();
    return redirect('/');
})->middleware('auth')->name('logout');

Route::view('dashboard', 'dashboard')
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::view('profile', 'profile')
    ->middleware(['auth'])
    ->name('profile');

require __DIR__.'/auth.php';