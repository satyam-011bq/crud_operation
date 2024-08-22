@extends('layouts.app')

@section('content')
    <style>
        .tasks-container {
            display: flex;
            flex-direction: column;
            align-items: center;
            margin: 20px auto;
            max-width: 600px;
        }

        .tasks-container h1 {
            text-align: center;
            margin-bottom: 20px;
        }

        .tasks-list {
            list-style-type: none;
            padding: 0;
            margin: 0;
            width: 100%;
        }

        .tasks-list li {
            display: flex;
            justify-content: space-between;
            align-items: center;
            background-color: #f8f9fa;
            border: 1px solid #ddd;
            border-radius: 5px;
            padding: 10px 20px;
            margin-bottom: 10px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        .task-buttons {
            display: flex;
            gap: 10px;
        }

        .task-buttons button {
            padding: 5px 10px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            color: white;
        }

        .task-buttons .update {
            background-color: #007bff;
        }

        .task-buttons .delete {
            background-color: #dc3545;
        }

        .task-buttons button:hover {
            opacity: 0.9;
        }

        .task-buttons .delete:hover {
            opacity: 0.8;
        }
    </style>

    <div class="tasks-container">
        <h1>All Tasks</h1>

        @if($tasks->isEmpty())
            <p>No tasks found.</p>
        @else
            <ul class="tasks-list">
                @foreach($tasks as $task)
                    <li>
                        {{ $task->name }}
                        <div class="task-buttons">
                            <!-- Update Button -->
                            <button class="update">Update</button>
                            
                            <!-- Delete Button -->
                            <button class="delete">Delete</button>
                        </div>
                    </li>
                @endforeach
            </ul>
        @endif
    </div>
@endsection
