<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\View\View;

class HomeController extends Controller
{
    public function index() : View {
        $tasks = \App\Models\Task::where('due_date', '>=', now())
            ->orderBy('due_date', 'asc')
            ->limit(20)
            ->get();
        $passedTasks = \App\Models\Task::where('due_date', '<', now())
            ->where('completed', false)
            ->orderBy('due_date', 'asc')
            ->limit(20)
            ->get();        
        return view('home.index',compact('tasks', 'passedTasks'));
    }
}
