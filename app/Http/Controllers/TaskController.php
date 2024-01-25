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

    public function create() {
        $categories = Category::all();
        $task = new Task();
        return view('task.create', compact('categories','task'));
    }

    public function show(Task $task) {
        return view('task.show', compact('task'));
    }

    public function edit(Task $task) {
        $categories = Category::all();
        return view('task.edit', compact('task', 'categories'));
    }

    public function store(TaskRequest $request, Task $task) {
        $answer = $this->ajax($request);
        if ($answer->getStatusCode() !== 200) {
            throw new Exception('Error creating task');
        }
        return redirect()->route('task.show', $task->id);
    }

    public function update(TaskRequest $request, Task $task) {
        $answer = $this->ajax($request);
        if ($answer->getStatusCode() !== 200) {
            throw new Exception('Error updating task');
        }
        return redirect()->route('task.show', $task->id);
    }

    public function destroy(Task $task) {
        $task->delete();
        return redirect()->route('task.index');
    }

    public function fetch(Request $request) {
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

        // // Send message to discord webhook
        // $message = "Tasks due between $startDate and $endDate, \n\n $tasks";
        // $webhook = "https://discord.com/api/webhooks/1178748329505595412/VUTPSeFHo3RAckfEceoOvsm60mPKv5gFAYEOURaUVJzvSoPtjWk5CZ_565h8VC80c9dO";
        // $data = array('content' => $message);
        // $curl = curl_init($webhook);
        // curl_setopt($curl, CURLOPT_HTTPHEADER, array('Content-Type:application/json'));
        // curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "POST");
        // curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode($data));
        // curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        // curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false); // Add this line
        // $result = curl_exec($curl);
        // if($result === false)
        // {
        //     // Throw an error if the request failed
        //     throw new Exception(curl_error($curl), curl_errno($curl));
        // }
        // curl_close($curl);
        // return $result;

    }

    public function ajax(Request $request) {
        switch ($request->getMethod()) {
            case 'POST':
                $task = new Task();
                $task->name = $request->name;
                $task->due_date = $request->due_date;
                $task->category_id = $request->category_id;
                $task->content = $request->content;
                $task->completed = $request->completed !== null;
                $task->save();
                return response()->json([
                    'status' => 'success',
                    'message' => 'Task created successfully',
                    'data' => $task
                ]);
            case 'PUT':
            case 'PATCH':
                $task = Task::find($request->id);
                $task->name = $request->name;
                $task->due_date = $request->due_date;
                $task->category_id = $request->category_id;
                $task->content = $request->content;
                $task->completed = $request->completed !== null;
                $task->save();
                return response()->json([
                    'status' => 'success',
                    'message' => 'Task updated successfully',
                    'data' => $task
                ]);
            case "DELETE":
                $task = Task::find($request->id);
                $task->delete();
                return response()->json([
                    'status' => 'success',
                    'message' => 'Task deleted successfully',
                    'data' => $task
                ]);
            default:
                return response()->json(['status' => 'error', 'message' => 'Invalid request type' ]);
        }
    }
}
