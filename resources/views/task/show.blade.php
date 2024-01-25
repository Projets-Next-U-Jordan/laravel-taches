@extends('layouts.app')

@section('title', "Task Details")

@section('content')
    <h1>{{ $task->name }}</h1>

    <p><strong>Due Date:</strong> {{ $task->due_date }}</p>
    <p><strong>Category:</strong> {{ $task->category->name }}</p>
    <p><strong>Content:</strong> {{ $task->content }}</p>
    <p><strong>Completed:</strong> {{ $task->completed ? 'Yes' : 'No' }}</p>

    <a href="{{ route('task.edit', $task->id) }}" class="btn btn-primary">Edit</a>
    <form action="{{ route('task.destroy', $task->id) }}" method="POST" style="display:inline;">
        @csrf
        @method('DELETE')
        <button type="submit" class="btn btn-danger">Delete</button>
    </form>
@endsection