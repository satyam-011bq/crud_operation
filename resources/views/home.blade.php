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
        <form action="{{ route('tasks.store') }}" method="POST" class="task-form">
            @csrf
            <input type="text" name="task" placeholder="Enter task" value="{{ old('task') }}">
            <button type="submit">Add Task</button>
        </form>
    </div>
</div>
@endsection
