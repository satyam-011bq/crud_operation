@extends('layouts.app')

@section('content')
    <style>
        nav {
    position:relative;
    top: 0;
    left: 0;
    width: 100%;
    background-color: #f8f9fa; /* Light background color */
    border-bottom: 1px solid #ddd; /* Border for separation */
    z-index: 1030; /* Ensure it sits above other content */
}

/* Navigation links container */
.flex-3 {
    display: flex;
    justify-content: space-around; /* Space out items evenly */
    align-items: center; /* Center items vertically */
    list-style: none; /* Remove default list styling */
    padding: 10px 20px; /* Padding around the links */
    margin: 0; /* Remove default margin */
}

/* Individual navigation items */
.flex-3 li {
    margin: 0; /* Remove default margin */
}

/* Navigation links */
.flex-3 li a {
    text-decoration: none; /* Remove underline */
    color: #007bff; /* Blue color for links */
    padding: 10px 15px; /* Padding around the text */
    display: block; /* Ensure the entire area is clickable */
    font-weight: 500; /* Slightly bolder text */
}

/* Hover state for links */
.flex-3 li a:hover {
    text-decoration: underline; /* Underline on hover */
    background-color: #e2e6ea; /* Light background on hover */
    border-radius: 4px; /* Slight rounding of corners */
}
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

        .task-buttons button,
        .task-buttons form {
            margin-left: 5px;
        }

        .task-buttons .edit {
            background-color: #007bff;
            color: white;
        }

        .task-buttons .delete {
            background-color: #dc3545;
            color: white;
        }

        .task-buttons button:hover,
        .task-buttons form button:hover {
            opacity: 0.9;
        }

        .task-buttons .delete:hover {
            opacity: 0.8;
        }

        .modal {
        display: none; /* Hidden by default */
        position: fixed; /* Stay in place */
        z-index: 1050; /* Sit on top */
        left: 0;
        top: 0;
        width: 100%;
        height: 100%;
        overflow: auto; /* Enable scroll if needed */
        background-color: rgba(0, 0, 0, 0.5); /* Black w/ opacity */
        padding-top: 60px;
    }

    /* Modal Content */
    .modal-content {
        background-color: #fff;
        margin: 5% auto;
        padding: 20px;
        border: 1px solid #888;
        width: 80%;
        max-width: 500px;
        border-radius: 8px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
    }

    /* Close Button */
    .modal-content .close {
        color: #aaa;
        float: right;
        font-size: 28px;
        font-weight: bold;
        cursor: pointer;
    }

    .modal-content .close:hover,
    .modal-content .close:focus {
        color: #000;
        text-decoration: none;
        cursor: pointer;
    }

    /* Form Elements */
    .modal-content input[type="text"] {
        width: 100%;
        padding: 10px;
        margin-top: 10px;
        border: 1px solid #ccc;
        border-radius: 4px;
        box-sizing: border-box; /* Add this to ensure padding doesn't affect width */
    }

    .modal-content button {
        margin-top: 20px;
        padding: 10px 20px;
        border: none;
        border-radius: 4px;
        color: #fff;
        cursor: pointer;
        font-size: 16px;
    }

    .modal-content .update {
        background-color: #007bff;
    }

    .modal-content .update:hover {
        background-color: #0056b3;
    }
    </style>
<nav>
    <ul class="flex-3">
        <li><a href="{{ url('/') }}">Home</a></li>
        <li><a href="{{ route('tasks.index') }}">Tasks</a></li>
        <li><a href="#">Recent Deleted Posts</a></li>
    </ul>
</nav>
    <div class="tasks-container">
        <h1>All Tasks</h1>

        @if($tasks->isEmpty())
            <p>No tasks found.</p>
        @else
            <ul class="tasks-list">
                @foreach($tasks as $task)
                    <li>
                        <span>{{ $task->name }}</span>

                        <!-- Buttons -->
                        <div class="task-buttons">
                            <!-- Edit Button -->
                            <button class="edit" onclick="openModal({{ $task->id }}, '{{ $task->name }}')">Edit</button>

                            <!-- Delete Button -->
                            <form action="{{ route('tasks.destroy', $task->id) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="delete">Delete</button>
                            </form>
                        </div>
                    </li>
                @endforeach
            </ul>
        @endif
    </div>

    <!-- Modal Structure -->
    <div id="editModal" class="modal">
    <div class="modal-content">
        <span class="close" onclick="closeModal()">&times;</span>
        <form id="editForm" action="{{ route('tasks.update', 'TASK_ID') }}" method="POST">
            @csrf
            @method('PUT')
            <div class="form-group">
                <label for="taskName">Task Name</label>
                <input type="text" name="name" id="taskName" value="">
            </div>
            <button type="submit" class="update">Update</button>
        </form>
    </div>
</div>
    <script>
        function openModal(id, name) {
            document.getElementById('editForm').action = '{{ url('/tasks') }}/' + id;
            document.getElementById('taskName').value = name;
            document.getElementById('editModal').style.display = 'block';
        }

        function closeModal() {
            document.getElementById('editModal').style.display = 'none';
        }

        window.onclick = function(event) {
            if (event.target == document.getElementById('editModal')) {
                closeModal();
            }
        }
    </script>
@endsection
