<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\Http\Request;
use App\Models\Image;

class TaskController extends Controller
{
    // Display a listing of tasks.
    public function index()
    {
        $tasks = Task::all();
        return view('home', compact('tasks'));
    }

    // Store a newly created task in storage.
    // TaskController.php

    public function store(Request $request)
    {
        // Validate input
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'status' => 'required|string|in:done,not-done',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', // Validation for image file
        ]);
    
        // Create a new task
        $task = Task::create([
            'name' => $request->name,
            'description' => $request->description,
            'status' => $request->status,
        ]);
    
        // Handle image upload if present
        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $imageName = time() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('images'), $imageName);
    
            // Create a new image record
            Image::create([
                'image_path' => 'images/' . $imageName,
                'task_id' => $task->id,
            ]);
        }
    
        // Return the created task as JSON
        return response()->json($task->load('images'), 201);
    }
    

    public function update(Request $request, $id)
    {
        $task = Task::findOrFail($id);
        
        // Validate request data
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'status' => 'required|string|in:done,not-done',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', // Validation for image file
        ]);
    
        // Update task details
        $task->name = $request->input('name');
        $task->description = $request->input('description');
        $task->status = $request->input('status');
        
        // Handle image upload if present
        if ($request->hasFile('image')) {
            // Delete old image if exists
            if ($task->images()->exists()) {
                $oldImage = $task->images()->first();
                $oldImagePath = public_path($oldImage->image_path);
                if (file_exists($oldImagePath)) {
                    unlink($oldImagePath);
                }
                $oldImage->delete(); // Remove old image record
            }
    
            // Process new image
            $file = $request->file('image');
            $imageName = time() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('images'), $imageName);
    
            // Create new image record
            Image::create([
                'image_path' => 'images/' . $imageName,
                'task_id' => $task->id, // Associate image with the task
            ]);
        }
    
        $task->save();
    
        \Log::info('Task Updated:', $task->toArray()); // Log the updated task data
    
        return response()->json($task->load('images')); // Optionally load the related images
    }
    


    // Remove the specified task from storage.
    public function destroy($id)
    {
        $task = Task::findOrFail($id);
    
        // Delete associated images
        if ($task->images()->exists()) {
            foreach ($task->images as $image) {
                $imagePath = public_path($image->image_path);
                if (file_exists($imagePath)) {
                    unlink($imagePath);
                }
                $image->delete(); // Remove image record
            }
        }
    
        $task->delete();
    
        return response()->json(['message' => 'Task deleted successfully']);
    }
    
}
