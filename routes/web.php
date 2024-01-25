<?php

use App\Http\Controllers\AjaxController;
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

Route::get('/ajax/tasks', [AjaxController::class, 'fetchTasks'])->name("ajax.tasks.fetch");
Route::post('/ajax/task', [AjaxController::class, 'createTask'])->name("ajax.task.create");
Route::put('/ajax/task', [AjaxController::class, 'updateTask'])->name("ajax.task.update");
Route::patch('/ajax/task', [AjaxController::class, 'updateTask'])->name("ajax.task.update");
Route::delete('/ajax/task', [AjaxController::class, 'deleteTask'])->name("ajax.task.delete");

Route::get('/tasks/json', [TaskController::class, 'fetch'])->name("task.fetch");

Route::get('/tasks/new', [TaskController::class, 'create'])->name("task.new");

Route::get('/tasks/{task}', [TaskController::class, 'show'])->name("task.show");
Route::get('/tasks/{task}/edit', [TaskController::class, 'edit'])->name("task.edit");

Route::post('/tasks/new', [TaskController::class, 'storeEdit'])->name("task.store");
Route::put('/tasks/{task}/edit', [TaskController::class, 'storeEdit'])->name("task.update");

Route::delete('/tasks/{task}/delete', [TaskController::class, 'destroy'])->name("task.destroy");