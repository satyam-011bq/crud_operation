<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    // Display a listing of tasks.
    public function index()
    {
        $tasks = Task::all();
        return view('home', compact('tasks'));
    }

    // Store a newly created task in storage.
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'status' => 'required|string|in:done,not-done',
            'image_path' => 'nullable|url',
        ]);

        $task = Task::create($request->all());

        return response()->json($task, 201); // Return the created task as JSON.
    }

    // Display the specified task.
    public function show($id)
    {
        $task = Task::findOrFail($id);
        return response()->json($task);
    }

    // Update the specified task in storage.
    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'status' => 'required|string|in:done,not-done',
            'image_path' => 'nullable|url',
        ]);

        $task = Task::findOrFail($id);
        $task->update($request->all());

        return response()->json($task);
    }

    // Remove the specified task from storage.
    public function destroy($id)
    {
        $task = Task::findOrFail($id);
        $task->delete();

        return response()->json(['message' => 'Task deleted successfully']);
    }
}
