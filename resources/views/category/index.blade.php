@extends('layouts.app')

@section('title',"Categories")

@section('content')
    <div class="d-flex gap-2 align-items-center">
        <h1>Categories</h1>
        <a class="btn btn-primary" href="{{ route('category.new') }}">+</a>
    </div>
    @foreach ($categories as $category)
	<span class="badge" style="background-color:{{ $category->color }}">
		<a class="h2 no-link-style" href="{{ route('category.show',$category) }}">{{ $category->name }}</a>
	</span>
    @endforeach
	{{ $categories->links('pagination::bootstrap-5') }}
@endsection