@extends('layouts.app')

@section('title', "Task Details")

@section('content')
    <h1>{{ $task->name }}</h1>

    <span><strong>Pour:</strong> {{ $task->due_date }}</span><br>
    @if ($task->category)
        <span><strong>Catégorie:</strong> {{ $task->category->name }}</span><br>
    @endif
    <span><strong>Fini:</strong> {{ $task->completed ? 'Yes' : 'No' }}</span><br>
    <span><strong>Contenu:</strong></span><br>
    <textarea readonly rows="8" style="width:100%">{{ $task->content }}</textarea><br>

    <a href="{{ route('task.edit', $task->id) }}" class="btn btn-primary">Edit</a>
    <form action="{{ route('task.destroy', $task->id) }}" method="POST" style="display:inline;">
        @csrf
        @method('DELETE')
        <button type="submit" class="btn btn-danger">Delete</button>
    </form>
@endsection