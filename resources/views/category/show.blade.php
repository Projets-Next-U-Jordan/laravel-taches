@extends('layouts.app')

@section('title',"Categories")

@section('content')

    {{-- Align the name, a edit button and a delete button which is a form with csrf --}}
    <div class="d-flex justify-content-between align-items-center">
        <h1>{{$category->name}}</h1>
        <div class="d-flex">
            <a href="{{route('category.edit',$category->id)}}" class="btn btn-warning">Modifier</a>
            <form action="{{route('category.destroy',$category->id)}}" method="POST">
                @csrf
                @method('DELETE')
                <button class="btn btn-danger ml-2">Supprimer</button>
            </form>
        </div>
    </div>

    <div class="category-color" style="background-color: {{$category->color}}"></div>
@endsection