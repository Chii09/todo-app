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

    public function edit($id)
    {
        $task = Task::findOrFail($id);
        return view('tasks.edit', ['task' => $task]);
    }

    public function store(Request $request) {
        $request->validate([
            'title' => 'required|max:255',
        ]);
        $task = new Task;
        $task->title = $request->input('title');
        $task->save();
        return redirect('/tasks');
    }

    public function update(Request $request, $id) {
        $task = Task::findOrFail($id);
        $request->validate([
            'title' => 'required|max:255',
        ]);
        $task->title = $request->input('title');
        $task->save();
        return redirect('/tasks');
    }

    public function toggle($id) {
        $task = Task::findOrFail($id);
        $task->is_completed = !$task->is_completed;
        $task->save();
        return redirect('/tasks');
    }

    public function destroy($id) {
        $task = Task::findOrFail($id);
        $task->delete();
        return redirect('/tasks');
    }
}
