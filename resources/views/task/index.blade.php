@extends('layouts.app')

@section('title',"Tâches")

@section('content')

<div class="d-flex gap-2 align-items-center">
    <h1>Tâches</h1>
    <a class="btn btn-primary" href="{{ route('task.new') }}">+</a>
</div>
@foreach ($tasks as $task)
<span class="badge" style="background-color:{{ $task->category->color ?? 'grey' }}">
    <a class="h2 no-link-style" href="{{ route('task.show',$task) }}">{{ $task->name }}</a>
</span>
@endforeach
{{ $tasks->links('pagination::bootstrap-5') }}

@endsection