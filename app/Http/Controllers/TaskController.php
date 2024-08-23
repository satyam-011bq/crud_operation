<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Task;

class TaskController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'task' => 'required|max:255',
        ]);

        $task = Task::create(['name' => $request->input('task')]);

        return response()->json([
            'id' => $task->id,
            'name' => $task->name
        ]);
    }

    public function index()
    {
        $tasks = Task::all();
        return view('home', compact('tasks'));
    }

    public function update(Request $request, $id)
    {
        $task = Task::find($id);
        $task->name = $request->input('name');
        $task->save();

        return response()->json(['name' => $task->name]);
    }

    public function destroy($id)
    {
        Task::find($id)->delete();
        return response()->json(['success' => true]);
    }
}
