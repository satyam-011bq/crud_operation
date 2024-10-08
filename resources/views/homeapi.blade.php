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
        margin: 70px auto 0;
        /* Adjust top margin to account for fixed navbar */
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

    input[type="text"],
    input[type="url"] {
        flex: 1;
        padding: 10px;
        border: 1px solid #ccc;
        border-radius: 5px;
        width: 500px;
        margin: 10px 0;
    }

    #descInput {
        flex: 1;
        padding: 10px;
        border: 1px solid #ccc;
        border-radius: 5px;
        width: 500px;
        gap: 10p;
        margin: 10px 0px;
        height: 100px;
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
        display: none;
        /* Hidden by default */
        position: fixed;
        /* Stay in place */
        z-index: 1050;
        /* Sit on top */
        left: 0;
        top: 0;
        width: 100%;
        height: 100%;
        overflow: auto;
        /* Enable scroll if needed */
        background-color: rgba(0, 0, 0, 0.5);
        /* Black w/ opacity */
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
        box-sizing: border-box;
        /* Add this to ensure padding doesn't affect width */
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

    .tasks-table {
        width: 100%;
        border-collapse: collapse;
    }

    .tasks-table th,
    .tasks-table td {
        padding: 12px;
        text-align: left;
    }

    .tasks-table th {
        background-color: #f4f4f4;
    }

    .tasks-table td {
        border-bottom: 1px solid #ddd;
    }

    .task-description {
        max-width: 600px;
        /* Adjust as needed */
        word-wrap: break-word;
    }

    .task-image {
        max-width: 100px;
        /* Adjust as needed */
        height: auto;
    }

    .actions {
        display: flex;
        gap: 10px;
    }

    .actions button {
        background-color: #007bff;
        color: white;
        border: none;
        padding: 6px 12px;
        cursor: pointer;
    }

    .actions button.delete {
        background-color: #dc3545;
    }

    .actions button:hover {
        opacity: 0.8;
    }

    .actions button.delete:hover {
        opacity: 0.8;
    }
</style>
<nav>
    <ul class="flex-3">
        <li><a href="{{ url('/') }}">Home</a></li>
        <li><a href="{{ route('tasks.index') }}">Tasks</a></li>
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
            <input type="text" name="name" placeholder="Enter title" id="taskInput" required>
            <input type="text" name="description" placeholder="Enter description" id="descInput" required>
            <br><br>
            <label for="status-done">
                <input type="radio" id="status-done" name="status" value="done">
                Done
            </label><br>
            <label for="status-not-done">
                <input type="radio" id="status-not-done" name="status" value="not-done">
                Not Done
            </label><br><br>
            <label for="image-url">Image URL:</label>
            <input type="url" id="imagePathInput" name="image_url" placeholder="Enter image URL">
            <br><br>
            <button type="submit">Add Task</button>
        </form>

        <div class="tasks-container mt-5">
            <h1>All Tasks</h1>
            <table class="tasks-table" id="tasksTable">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Description</th>
                        <th>Status</th>
                        <th>Image</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody id="tasksList">
                    @foreach($tasks as $task)
                    <tr data-id="{{ $task->id }}">
                        <td>{{ $task->name }}</td>
                        <td class="task-description">{{ $task->description }}</td>
                        <td>{{ $task->status }}</td>
                        <td><img src="{{ $task->image_path }}" alt="Task Image" class="task-image"></td>
                        <td class="actions">
                            <button class="edit" onclick="openModal({{ $task->id }}, '{{ $task->name }}', '{{ $task->description }}', '{{ $task->status }}', '{{ $task->image_path }}')">Edit</button>
                            <button class="delete" onclick="deleteTask({{ $task->id }})">Delete</button>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <!-- Modal Structure -->
        <div id="editModal" class="modal" style="display: none;">
            <div class="modal-content">
                <span class="close" onclick="closeModal()">&times;</span>
                <form id="editForm" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="form-group">
                        <label for="taskName">Task Name</label>
                        <input type="text" name="name" id="taskName" required>
                    </div>
                    <div class="form-group">
                        <label for="taskDesc">Description</label>
                        <input type="text" name="description" id="taskDesc" required>
                    </div>
                    <div class="form-group">
                        <label>Status</label><br>
                        <label>
                            <input type="radio" name="status" value="done"> Done
                        </label>
                        <label>
                            <input type="radio" name="status" value="not-done"> Not Done
                        </label>
                    </div>
                    <div class="form-group">
                        <label for="taskImagePath">Image URL</label>
                        <input type="url" name="image_path" id="taskImagePath" >
                    </div>
                    <button type="submit" class="update">Update</button>
                </form>
            </div>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
  $(document).ready(function() {
    // Fetch tasks and render them on page load
    $.ajax({
        url: '{{ url('/api/tasks') }}',
        type: 'GET',
        success: function(response) {
            response.forEach(function(task) {
                $('#tasksList').append(
                    '<tr data-id="' + task.id + '">' +
                    '<td>' + task.name + '</td>' +
                    '<td>' + task.description + '</td>' +
                    '<td>' + task.status + '</td>' +
                    '<td><img src="' + task.image_path + '" alt="Task Image" style="max-width: 100px;"></td>' +
                    '<td>' +
                    '<button class="edit" onclick="openModal(' + task.id + ', \'' + task.name + '\', \'' + task.description + '\', \'' + task.status + '\', \'' + task.image_path + '\')">Edit</button>' +
                    '<button class="delete" onclick="deleteTask(' + task.id + ')">Delete</button>' +
                    '</td>' +
                    '</tr>'
                );
            });
        },
        error: function() {
            console.log('Error fetching tasks');
        }
    });

    // Handle form submission for creating tasks
    $('#taskForm').on('submit', function(e) {
        e.preventDefault();
        var taskName = $('#taskInput').val();
        var taskDesc = $('#descInput').val();
        var taskStatus = $('input[name="status"]:checked').val();
        var taskImagePath = $('#imagePathInput').val();

        $.ajax({
            url: '{{ url('/api/tasks') }}',
            type: 'POST',
            data: {
                name: taskName,
                description: taskDesc,
                status: taskStatus,
                image_path: taskImagePath
            },
            success: function(response) {
                $('#tasksList').append(
                    '<tr data-id="' + response.id + '">' +
                    '<td>' + response.name + '</td>' +
                    '<td>' + response.description + '</td>' +
                    '<td>' + response.status + '</td>' +
                    '<td><img src="' + response.image_path + '" alt="Task Image" style="max-width: 100px;"></td>' +
                    '<td>' +
                    '<button class="edit" onclick="openModal(' + response.id + ', \'' + response.name + '\', \'' + response.description + '\', \'' + response.status + '\', \'' + response.image_path + '\')">Edit</button>' +
                    '<button class="delete" onclick="deleteTask(' + response.id + ')">Delete</button>' +
                    '</td>' +
                    '</tr>'
                );
                $('#taskInput').val('');
                $('#descInput').val('');
                $('input[name="status"]').prop('checked', false);
                $('#imagePathInput').val('');
            },
            error: function() {
                alert('Failed to create task.');
            }
        });
    });

    // Handle form submission for updating tasks
    $('#editForm').on('submit', function(e) {
        e.preventDefault();
        var id = $('#editForm').attr('data-id');
        var taskName = $('#taskName').val();
        var taskDesc = $('#taskDesc').val();
        var taskStatus = $('input[name="status"]:checked').val();
        var taskImagePath = $('#taskImagePath').val();

        $.ajax({
            url: '{{ url('/api/tasks') }}/' + id,
            type: 'PUT',
            data: {
                name: taskName,
                description: taskDesc,
                status: taskStatus,
                image_path: taskImagePath
            },
            success: function(response) {
                var row = $('tr[data-id="' + id + '"]');
                row.find('td').eq(0).text(response.name);
                row.find('td').eq(1).text(response.description);
                row.find('td').eq(2).text(response.status);
                row.find('img').attr('src', response.image_path);
                closeModal();
                alert('Task updated successfully!');
            },
            error: function(xhr) {
                console.error(xhr.responseText);
                alert('Failed to update task. Please try again.');
            }
        });
    });

    // Handle task deletion
    window.deleteTask = function(id) {
        $.ajax({
            url: '{{ url('/api/tasks') }}/' + id,
            type: 'DELETE',
            success: function() {
                $('tr[data-id="' + id + '"]').remove();
                alert('Task deleted successfully!');
            },
            error: function() {
                alert('Error deleting task. Please try again.');
            }
        });
    };

    // Open edit modal
    window.openModal = function(id, name, description, status, imagePath) {
        $('#taskName').val(name);
        $('#taskDesc').val(description);
        $('input[name="status"]').prop('checked', false);
        $('input[name="status"][value="' + status + '"]').prop('checked', true);
        $('#editForm').attr('data-id', id);
        $('#editModal').show();
    }

    // Close edit modal
    window.closeModal = function() {
        $('#editModal').hide();
    }

    $(window).on('click', function(event) {
        if ($(event.target).is('#editModal')) {
            closeModal();
        }
    });
});

</script>

@endsection
