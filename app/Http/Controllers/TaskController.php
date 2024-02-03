<?php

namespace App\Http\Controllers;

use App\Http\Requests\TaskRequest;
use App\Models\Category;
use App\Models\Task;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Pagination\Paginator;

class TaskController extends Controller
{

    public function index() {
        // Show a paginated list of tasks with Paginator
        $page = $_GET['page'] ??= 1;
        Paginator::currentPageResolver(function () use ($page) {
            return $page;
        });
        $tasks = Task::query();
        $tasks = $tasks
            ->orderBy('due_date', 'asc')
            ->where('user_id', auth()->id())
            ->paginate(10);
        $categories = Category::all();
        return view('task.index', compact('tasks', 'categories'));
    }

    public function calendar(Request $request) {
        $startDate = $request->startDate ?? now()->startOfMonth();
        $endDate = $request->endDate ?? now()->endOfMonth();
        $tasks = Task::whereBetween('due_date', [$startDate, $endDate])->where('user_id', auth()->id())->get();
        $categories = Category::all();
        return view('task.calendar', compact('startDate','endDate', 'categories'));
    }

    public function show(Task $task) {
        return view('task.show', compact('task'));
    }

    public function create() {
        $task = new Task();
        $categories = Category::all();
        return view('task.create', compact('task','categories'));
    }

    public function edit(Task $task) {
        if ($task->user_id !== auth()->id()) {
            abort(403);
        }
        $categories = Category::all();
        return view('task.edit', compact('task', 'categories'));
    }

    public function storeEdit(TaskRequest $request, Task $task = null) {
        if ($task && $task->user_id !== auth()->id()) {
            abort(403);
        }
        $task = $task ?? new Task();
        $task->name = $request->name;
        $task->user_id = auth()->id();
        $task->due_date = $request->due_date ?? $task->due_date ?? now();
        $task->category_id = $request->category_id;
        $task->content = $request->content;
        $task->completed = $request->completed !== null;
        $task->save();
        return redirect()->route('task.show', $task->id);
    }

    public function destroy(Task $task) {
        if ($task->user_id !== auth()->id()) {
            abort(403);
        }
        $task->delete();
        return redirect()->route('task.index');
    }
}
