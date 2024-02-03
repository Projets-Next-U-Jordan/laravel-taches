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
        $tasks = Task::whereBetween('due_date', [$startDate, $endDate])->where('user_id', auth()->id())->get();

        $events = $tasks->map(function($task) {
            return [
                'id' => $task->id,
                'name' => $task->name,
                'start' => $task->due_date,
                // 'url' => route('task.show', $task->id)
                'category_id' => $task->category ? $task->category->id : null,
                'category' => $task->category ? $task->category->name : null,
                'color' => $task->category ? $task->category->color : null,
                'content' => $task->content ?? '',
                'completed' => $task->completed ?? false,
            ];
        });

        return response()->json($events);
    }

    public function createTask(TaskRequest $taskRequest) {
        $task = new Task();
        $task->name = $taskRequest->name;
        $task->user_id = auth()->id();
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
        // Test if the user loggedin is the owner of the task
        $task = Task::find($taskRequest->id);
        if ($task->user_id !== auth()->id()) {
            return response()->json([
                'status' => 'error',
                'message' => 'You are not allowed to update this task',
            ], 403);
        }


        $task->name = $taskRequest->name;
        $task->user_id = auth()->id();
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
        if ($task->user_id !== auth()->id()) {
            return response()->json([
                'status' => 'error',
                'message' => 'You are not allowed to update this task',
            ], 403);
        }
        $task->delete();
        return response()->json([
            'status' => 'success',
            'message' => 'Task deleted successfully',
            'data' => $task
        ]);
    }

}
