@extends('layouts.app')

@section('title', 'Home')

@section('content')
<style>
    /* Navigation Styles */
    nav {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        background-color: #f8f9fa;
        border-bottom: 1px solid #ccc;
        z-index: 1030;
    }

    .flex-3 {
        display: flex;
        justify-content: space-around;
        align-items: center;
        list-style-type: none;
        padding: 10px 20px;
        margin: 0;
    }

    .flex-3 li {
        padding: 0;
    }

    .flex-3 li a {
        text-decoration: none;
        color: #007bff;
        padding: 10px;
        display: block;
    }

    .flex-3 li a:hover {
        text-decoration: underline;
    }

    /* Content Container */
    .container {
        max-width: 1200px;
        margin: 70px auto 0; /* Adjust top margin to account for fixed navbar */
        padding: 20px;
    }

    /* Jumbotron Styles */
    .jumbotron {
        background-color: #e9ecef;
        padding: 2rem;
        border-radius: 5px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    }

    /* Form Styles */
    .task-form {
        display: flex;
        gap: 10px;
        margin-top: 10px;
    }

    input[type="text"] {
        flex: 1;
        padding: 10px;
        border: 1px solid #ccc;
        border-radius: 5px;
    }

    button {
        padding: 10px 20px;
        background-color: #007bff;
        color: white;
        border: none;
        border-radius: 5px;
        cursor: pointer;
    }

    button:hover {
        background-color: #0056b3;
    }

    /* Alert Styles */
    .alert {
        margin-top: 20px;
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
        <li><a href="{{ route('home') }}">Tasks</a></li>
        <li><a href="#">Recent Deleted Posts</a></li>
    </ul>
</nav>

<div class="container">
    <div class="jumbotron mt-5">
        <h1 class="display-4">CRUD Application</h1>
        <p class="lead">Task Management</p>
        <hr class="my-4">

        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif
        
        <!-- Form for inserting task -->
        <form id="taskForm" method="POST">
            @csrf
            <input type="text" name="task" placeholder="Enter task" id="taskInput">
            <button type="submit">Add Task</button>
        </form>
    </div>

    <div class="tasks-container">
        <h1>All Tasks</h1>

        <ul class="tasks-list" id="tasksList">
            @foreach($tasks as $task)
                <li data-id="{{ $task->id }}">
                    <span>{{ $task->name }}</span>

                    <!-- Buttons -->
                    <div class="task-buttons">
                        <!-- Edit Button -->
                        <button class="edit" onclick="openModal({{ $task->id }}, '{{ $task->name }}')">Edit</button>

                        <!-- Delete Button -->
                        <button class="delete" onclick="deleteTask({{ $task->id }})">Delete</button>
                    </div>
                </li>
            @endforeach
        </ul>
    </div>

    <!-- Modal Structure -->
    <div id="editModal" class="modal">
        <div class="modal-content">
            <span class="close" onclick="closeModal()">&times;</span>
            <form id="editForm" method="POST">
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
</div>

<script>
    $(document).ready(function() {
        // Handle task creation
        $('#taskForm').on('submit', function(e) {
            e.preventDefault();
            var taskName = $('#taskInput').val();
            $.ajax({
                url: '{{ route('tasks.store') }}',
                type: 'POST',
                data: {
                    _token: $('meta[name="csrf-token"]').attr('content'),
                    task: taskName
                },
                success: function(response) {
                    $('#tasksList').append(
                        '<li data-id="' + response.id + '">' +
                        '<span>' + response.name + '</span>' +
                        '<div class="task-buttons">' +
                        '<button class="edit" onclick="openModal(' + response.id + ', \'' + response.name + '\')">Edit</button>' +
                        '<button class="delete" onclick="deleteTask(' + response.id + ')">Delete</button>' +
                        '</div>' +
                        '</li>'
                    );
                    $('#taskInput').val('');
                }
            });
        });

        // Handle task update
        $('#editForm').on('submit', function(e) {
    e.preventDefault();
    var id = $('#editForm').attr('data-id');
    var taskName = $('#taskName').val();

    $.ajax({
        url: '{{ url('/tasks') }}/' + id,
        type: 'PUT',
        data: {
            _token: $('meta[name="csrf-token"]').attr('content'),
            name: taskName
        },
        success: function(response) {
            // Update the list item in the DOM with the new name
            $('li[data-id="' + id + '"] span').text(response.name);

            // Close the modal
            closeModal();
        }
    });
});

        // Handle task deletion
        window.deleteTask = function(id) {
            $.ajax({
                url: '{{ url('/tasks') }}/' + id,
                type: 'DELETE',
                data: {
                    _token: $('meta[name="csrf-token"]').attr('content')
                },
                success: function() {
                    $('li[data-id="' + id + '"]').remove();
                }
            });
        };
    });

    function openModal(id) {
    // Clear any existing value in the input field
    $('#taskName').val('');

    // Set the form data-id to the current task ID
    $('#editForm').attr('data-id', id);

    // Fetch the current task name from the server
    $.ajax({
        url: '{{ url('/tasks') }}/' + id + '/edit',
        type: 'GET',
        success: function(response) {
            // Set the input field value to the current task name
            $('#taskName').val(response.name).focus();
            
            // Show the modal
            $('#editModal').show();
        }
    });
}


function closeModal() {
    $('#editModal').hide(); // Hide the modal
}

    $(window).on('click', function(event) {
        if ($(event.target).is('#editModal')) {
            closeModal();
        }
    });
</script>
@endsection
