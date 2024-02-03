@extends('layouts.app')

@section('title',"Catégories")

@section('content')

    <h1>Modification de: {{ $category->name }}</h1>
    @include('forms.categoryCreateEdit')

@endsection