@extends('layouts.app')

@section('title',"IDK")

@section('additionalHeader')
    <script src='https://cdn.jsdelivr.net/npm/fullcalendar@6.1.10/index.global.min.js'></script>
    @include('scripts.calendar')
@endsection

@section('content')
    <div id='calendar'></div>
    @include('modals.createEditTask')
    @include('modals.showTask')
@endsection