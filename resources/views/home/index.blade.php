@extends('layouts.app')

@section('title', 'Accueil')

@section('content')
    <h1>Aujourd'hui {{ date('d/m/Y H:i:s') }}</h1>
    @if (count($passedTasks) > 0)
        <h2>Tâches en retard</h2>
        <ul>
            @foreach ($passedTasks as $task)
                <li>{{$task->name}}</li>
            @endforeach
        </ul>
    @endif

    @if (count($tasks) > 0)
        <h2>
            Tâches du jour
        </h2>
        <ul>
            @foreach ($tasks as $task)
                <li>{{ $task->name }}</li>
            @endforeach
        </ul>
    @else
        <h3>Aucune tâche pour aujourd'hui.</h3>
    @endif

@endsection