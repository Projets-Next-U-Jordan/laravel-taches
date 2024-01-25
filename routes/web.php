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

Route::get('/tasks/new', [TaskController::class, 'create'])->name("task.new");
Route::post('/tasks/new', [TaskController::class, 'store'])->name("task.store");

Route::get('/tasks/{task}', [TaskController::class, 'show'])->name("task.show");
Route::get('/tasks/{task}/edit', [TaskController::class, 'edit'])->name("task.edit");
Route::put('/tasks/{task}/edit', [TaskController::class, 'update'])->name("task.update");
Route::delete('/tasks/{task}/delete', [TaskController::class, 'destroy'])->name("task.destroy");