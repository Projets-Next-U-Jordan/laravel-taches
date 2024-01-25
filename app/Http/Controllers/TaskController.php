<?php

namespace App\Http\Controllers;

use App\Http\Requests\TaskRequest;
use App\Models\Category;
use App\Models\Task;
use Exception;
use Illuminate\Http\Request;

class TaskController extends Controller
{

    public function index(Request $request) {
        $startDate = $request->startDate ?? now()->startOfMonth();
        $endDate = $request->endDate ?? now()->endOfMonth();
        $tasks = Task::whereBetween('due_date', [$startDate, $endDate])->get();
        $categories = Category::all();
        return view('task.index', compact('tasks','startDate','endDate', 'categories'));
    }

    public function show(Task $task) {
        return view('task.show', compact('task'));
    }

    public function create() {
        $categories = Category::all();
        $task = new Task();
        return view('task.create', compact('task','categories'));
    }

    public function edit(Task $task) {
        $categories = Category::all();
        return view('task.edit', compact('task', 'categories'));
    }

    public function storeEdit(TaskRequest $request, Task $task) {
        $task->name = $request->name;
        $task->due_date = $request->due_date ?? $task->due_date ?? now();
        $task->category_id = $request->category_id;
        $task->content = $request->content;
        $task->completed = $request->completed !== null;
        $task->save();
        return redirect()->route('task.show', $task->id);
    }

    public function destroy(Task $task) {
        $task->delete();
        return redirect()->route('task.index');
    }
}
