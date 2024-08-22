<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Task;

class TaskController extends Controller
{
    public function index()
    {
        $tasks = Task::all();
        return view('tasks.index', compact('tasks'));
    }

    public function store(Request $request)
    {
        // Validate the request data
        $request->validate([
            'task' => 'required|max:255',
        ]);

        // Create a new task
        Task::create(['name' => $request->task]);

        // Redirect back with a success message
        return redirect()->back()->with('success', 'Task added successfully!');
    }
}
