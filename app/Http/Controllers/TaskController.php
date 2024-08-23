<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Task;

class TaskController extends Controller
{
    public function store(Request $request)
    {
        // Validate the request data
        $data=$request->input('task');
        $request->validate([
            'task' => 'required|max:255',
        ]);

        // Create a new task
        Task::create(['name' => $data]);

        // Redirect back with a success message
        return redirect()->back()->with('success', 'Task added successfully!');
    }

    public function index(Request $request)
    {
        $tasks = Task::all();
    
        // Retrieve the ID of the task to be edited from the session
        $editTaskId = $request->session()->get('edit_task_id');
    
        return view('tasks.index', compact('tasks', 'editTaskId'));
    }
    
    public function edit($id)
    {
        
        session(['edit_task_id' => $id]);
       
        return redirect()->route('tasks.index');
    }
    
    public function update(Request $request, $id)
    {
        $task = Task::find($id);
    
        // Update the task with the new name
        $task->name = $request->input('name');
        $task->save();
    
        // Clear the edit task ID from the session
        $request->session()->forget('edit_task_id');
    
        return redirect()->route('tasks.index')->with('success', 'Task updated successfully');
    }
    
    public function destroy($id)
    {
        $task = Task::find($id);
        $task->delete();
    
        return redirect()->route('tasks.index')->with('success', 'Task deleted successfully');
    }
    
}
