@extends('layouts.app')

@section('title',"IDK")

@section('additionalHeader')
    <script src='https://cdn.jsdelivr.net/npm/fullcalendar@6.1.10/index.global.min.js'></script>

    <script>
        let calendar;
        document.addEventListener('DOMContentLoaded', function() {
            let calendarEl = document.getElementById('calendar');
            calendar = new FullCalendar.Calendar(calendarEl, {
                firstDay: 1,
                initialView: $(window).width() < 765 ? "timeGridToday" : 'timeGridWeek',
                locale: 'fr',
                events: '{{ route('task.fetch') }}',
                nowIndicator: true,
                allDaySlot: false,
                views: {
                    timeGridToday: {
                        type: 'timeGrid',
                        duration: { days: 1 }
                    }
                },
                customButtons: {
                    myCustomButton: {
                        text: 'Add Event',
                        click: function() {
                            window.location.href = {{ route("task.new") }}; // Replace with the actual path
                        }
                    }
                },
                headerToolbar: {
                    left: 'dayGridMonth,timeGridWeek,timeGridDay',
                    center: 'title',
                    right: 'myCustomButton prev,today,next'
                },
                eventContent: function(arg) {
                    let arrayOfDomNodes = [];

                    // Create main frame div
                    let mainFrameEl = document.createElement('div');
                    mainFrameEl.className = 'fc-event-main-frame';

                    // Create time div
                    let timeEl = document.createElement('div');
                    timeEl.className = 'fc-event-time';
                    timeEl.innerHTML = arg.timeText;

                    if (arg.event.extendedProps.category !== undefined) {

                        timeEl.innerHTML += ' · ';
                        // Create category span
                        let categorySpan = document.createElement('span');
                        categorySpan.className = 'calendar-event-category';
                        categorySpan.title = arg.event.extendedProps.category;
                        categorySpan.innerHTML = arg.event.extendedProps.category;

                        timeEl.appendChild(categorySpan);

                    }
                    // Create title container div
                    let titleContainerEl = document.createElement('div');
                    titleContainerEl.className = 'fc-event-title-container';

                    // Create title div
                    let titleEl = document.createElement('div');
                    titleEl.className = 'fc-event-title fc-sticky';
                    titleEl.innerHTML = arg.event.title;

                    // Append time and title divs to main frame div
                    titleContainerEl.appendChild(titleEl);
                    mainFrameEl.appendChild(timeEl);
                    mainFrameEl.appendChild(titleContainerEl);

                    arrayOfDomNodes.push(mainFrameEl);

                    return { domNodes: arrayOfDomNodes };
                }
            });

            calendar.render();

            // Set calendar height
            setInterval(() => {
                let calendarEl = document.getElementById('calendar');
                if (calendarEl === null) return;
                let calendarTop = calendarEl.getBoundingClientRect().top;
                let remainingHeight = window.innerHeight - calendarTop - 50;
                calendar.setHeight(remainingHeight);
            }, 100);
        });

        $(window).resize(function() {
            if (calendar === undefined) return;
            let currentView = calendar.view.type;
            let newView = $(window).width() < 765 ? "timeGridToday" : 'timeGridWeek';
            if (currentView !== newView) {
                calendar.changeView(newView);
            }
        });

    </script>
@endsection

@section('content')
    <div id='calendar'></div>
@endsection