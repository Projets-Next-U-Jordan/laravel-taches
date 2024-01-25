@extends('layouts.app')

@section('title',"Tâches")

@section('additionalHeader')
    <link rel="stylesheet" href="css/calendar.css">
    <script src='https://cdn.jsdelivr.net/npm/fullcalendar@6.1.10/index.global.min.js'></script>
    <script src="{{asset('js/fullcalendar-locales-all.min.js')}}"></script>
    @include('scripts.calendar')
@endsection

@section('content')
    <div id='calendar'></div>
    @include('modals.createEditTask')
    @include('modals.showTask')

<div class="toast" role="alert" aria-live="assertive" aria-atomic="true">
    <div class="toast-header">
        <strong class="mr-auto">Error</strong>
        <button type="button" class="ml-2 mb-1 close" data-dismiss="toast" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
    <div class="toast-body">
    </div>
</div>
@endsection