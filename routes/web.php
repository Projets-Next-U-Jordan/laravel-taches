<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\TaskController;
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

Route::get('/', [HomeController::class, 'index'])->name("home.index");
Route::get('/tasks', [TaskController::class, 'index'])->name("task.index");
Route::post('/tasks', [TaskController::class, 'ajax']);
Route::put('/tasks', [TaskController::class, 'ajax']);
Route::delete('/tasks', [TaskController::class, 'ajax']);

Route::get('/tasks/json', [TaskController::class, 'fetch'])->name("task.fetch");
Route::get('/tasks/new', [TaskController::class, 'fetch'])->name("task.new");