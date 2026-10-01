<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Task;

class TaskController extends Controller
{
    public function index()
    {
        return view('tasks.index', ['tasks' => Task::all()]);
    }

    public function create()
    {
        return view('tasks.create');
    }

    public function store(Request $request) {
        $task = new Task;
        $task->title = $request->input('title');
        $task->save();
        return redirect('/tasks');
    }
}
