<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Task;

class TaskController extends Controller
{
    // Fetch all tasks
    public function index()
    {
        return response()->json(Task::all());
    }

    // Store a new task
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string|max:255',
            'status' => 'required|in:done,not-done',
            'image_path' => 'nullable|url',
        ]);

        $task = Task::create($request->all());
        return response()->json($task, 201);
    }

    // Update an existing task
    public function update(Request $request, $id)
    {
        $task = Task::findOrFail($id);
        
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string|max:255',
            'status' => 'required|in:done,not-done',
            'image_path' => 'nullable|url',
        ]);

        $task->update($request->all());
        return response()->json($task, 200);
    }

    // Delete a task
    public function destroy($id)
    {
        $task = Task::findOrFail($id);
        $task->delete();
        return response()->json(null, 204);
    }
}
