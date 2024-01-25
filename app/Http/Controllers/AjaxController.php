<?php

namespace App\Http\Controllers;

use App\Http\Requests\TaskRequest;
use App\Models\Task;
use Illuminate\Http\Request;

class AjaxController extends Controller
{
    
    public function fetchTasks(Request $request) {
        $startDate = $request->start ?? now()->startOfMonth();
        $endDate = $request->end ?? now()->endOfMonth();
        $tasks = Task::whereBetween('due_date', [$startDate, $endDate])->get();

        $events = $tasks->map(function($task) {
            return [
                'id' => $task->id,
                'name' => $task->name,
                'start' => $task->due_date,
                // 'url' => route('task.show', $task->id)
                'category_id' => $task->category->id, // 'category' is a custom property, not a native one
                'category' => $task->category->name, // 'category' is a custom property, not a native one
                'color' => $task->category->color,
                'content' => $task->content ?? '',
                'completed' => $task->completed ?? false,
            ];
        });

        return response()->json($events);
    }

    public function createTask(TaskRequest $taskRequest) {
        $task = new Task();
        $task->name = $taskRequest->name;
        $task->due_date = $taskRequest->due_date;
        $task->category_id = $taskRequest->category_id;
        $task->content = $taskRequest->content;
        $task->completed = $taskRequest->completed !== null;
        $task->save();
        return response()->json([
            'status' => 'success',
            'message' => 'Task created successfully',
            'data' => $task
        ]);
    }

    public function updateTask(TaskRequest $taskRequest) {
        $task = Task::find($taskRequest->id);
        $task->name = $taskRequest->name;
        $task->due_date = $taskRequest->due_date ?? $task->due_date;
        $task->category_id = $taskRequest->category_id;
        $task->content = $taskRequest->content;
        $task->completed = $taskRequest->completed !== null;
        $task->save();
        return response()->json([
            'status' => 'success',
            'message' => 'Task updated successfully',
            'data' => $task
        ]);
    }

    public function deleteTask(Request $taskRequest) {
        $task = Task::find($taskRequest->id);
        $task->delete();
        return response()->json([
            'status' => 'success',
            'message' => 'Task deleted successfully',
            'data' => $task
        ]);
    }

}
