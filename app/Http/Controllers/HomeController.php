<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\View\View;

class HomeController extends Controller
{
    public function index() : View {
        $users = \App\Models\User::all();
        $tasks = \App\Models\Task::where('due_date', '>=', now())
            ->orderBy('due_date', 'asc')
            ->limit(20)
            ->where('user_id', auth()->id())
            ->get();
        $passedTasks = \App\Models\Task::where('due_date', '<', now())
            ->where('completed', false)
            ->orderBy('due_date', 'asc')
            ->limit(20)
            ->get();        
        return view('home.index',compact('tasks', 'passedTasks', 'users'));
    }
}
