<script>
    let currentEvent;

    function addModal(date) {
        $('#taskLabel').text('Nouvelle Tâche');
        $('#taskForm').trigger('reset');
        currentEvent = undefined;
        $('#taskForm #method').val('POST');

        // Convert date to client local time zone, for example I am UTC+1
        let formattedDate = new Date(date.getTime() - (date.getTimezoneOffset() * 60000)).toISOString().slice(0, -8);
        $('#taskForm #start').val(formattedDate);

        $('#taskForm #start').prop('disabled', false);

        $('#task').modal('show');
    }

    function editModal(id) {
        if (currentEvent === undefined) 
            currentEvent = calendar.getEventById(id);
        if (currentEvent === null) 
            return;
        $('#taskForm #method').val('PUT');
        $('#taskLabel').text('Modifier la Tâche');


        let name = currentEvent.extendedProps.name;
        let start = currentEvent.start;
        let content = currentEvent.extendedProps.content;
        let category = currentEvent.extendedProps.category;
        let category_id = currentEvent.extendedProps.category_id;

        // Set select value to current category

        $('#taskForm').trigger('reset');

        $('#taskForm #id').val(id);
        $('#taskForm #name').val(name);
        // Convert date to client local time zone, for example I am UTC+1
        start = new Date(start.getTime() - (start.getTimezoneOffset() * 60000)).toISOString().slice(0, -8);

        $('#taskForm #start').val(start);
        $('#taskForm #start').prop('disabled', true);
        
        $('#taskForm #category option').each(function() {
            if ($(this).val() == category_id) {
                $(this).prop('selected', true);
            }
        });

        $('#taskForm #content').val(content);

        $('#taskForm #checkbox').prop('checked', currentEvent.extendedProps.completed);


        $('#task').modal('show');
    }

    function showModal(id) {
        let name = currentEvent.extendedProps.name;
        let start = currentEvent.start;
        let content = currentEvent.extendedProps.content;
        let category = currentEvent.extendedProps.category;
        let completed = currentEvent.extendedProps.completed;

        $('#viewTask #viewTaskLabel').text(name);
        $('#viewTask #viewStart').text(start.toISOString());
        $('#viewTask #viewContent').text(content);
        $('#viewTask #viewCategory').text(category);
        $('#viewTask #viewCompleted').text(completed ? 'Oui' : 'Non');
        $('#viewTask #deleteId').val(id);

        $('#viewTask').modal('show');
    }

    const options = {
        firstDay: 1,
        initialView: $(window).width() < 765 ? "timeGridToday" : 'timeGridWeek',
        locale: 'fr',
        height: 'auto',
        events: '{{ route('ajax.tasks.fetch') }}',
        nowIndicator: true,
        dateClick: function(info) {
            if (info.date < new Date()) return;
            addModal(info.date);
        },
        eventClick: function(info) {
            currentEvent = info.event;
            showModal(info.event.id);
        },
        allDaySlot: false,
        views: {
            timeGridToday: {
                type: 'timeGrid',
                duration: { days: 1 }
            }
        },
        customButtons: {
            myCustomButton: {
                text: '+',
                click: function() {
                    window.location.href = '{{ route('task.new') }}'; // Replace with the actual path
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

            if (arg.event.extendedProps.completed) {
                timeEl.innerHTML += ' · ';
                // Create completed span
                let completedSpan = document.createElement('span');
                completedSpan.className = 'calendar-event-completed';
                completedSpan.title = 'Tâche complétée';
                completedSpan.innerHTML = '✓';

                timeEl.appendChild(completedSpan);
            }
            // Create title container div
            let titleContainerEl = document.createElement('div');
            titleContainerEl.className = 'fc-event-title-container';

            // Create title div
            let titleEl = document.createElement('div');
            titleEl.className = 'fc-event-title fc-sticky';
            titleEl.innerHTML = arg.event.extendedProps.name;
            if (arg.event.extendedProps.content !== "") {
                titleEl.style.textDecoration = 'underline';
            }

            // Append time and title divs to main frame div
            titleContainerEl.appendChild(titleEl);
            mainFrameEl.appendChild(timeEl);
            mainFrameEl.appendChild(titleContainerEl);

            arrayOfDomNodes.push(mainFrameEl);

            return { domNodes: arrayOfDomNodes };
        }
    }

    let calendar;
    document.addEventListener('DOMContentLoaded', function() {
        let calendarEl = document.getElementById('calendar');
        calendar = new FullCalendar.Calendar(calendarEl, options);

        calendar.render();

        // Set calendar height


        $('#editButton').on('click', function() {
            // Hide the show modal
            $('#viewTask').modal('hide');   

            $('#task .modal-footer .btn-secondary').on('click', function() {
                if (currentEvent === undefined) return;
                $('#viewTask').modal('show');
            });

            // Show the edit modal
            editModal(currentEvent.id);
        });

        $('#viewTask #showButton').on('click', function() {
            if (currentEvent === undefined) return;

            window.location.href = '{{ route('task.show', '') }}/'+currentEvent.id;
        });
        $('#viewTask #deleteButton').on('click', function() {
            if (currentEvent === undefined) return;

            let id = currentEvent.id;
            let url = '{{ route('ajax.task.delete') }}';
            let method = 'DELETE';
            $.ajax({
                url: url,
                method: method,
                data: { id: id, _token: '{{ csrf_token() }}', _method: method},
                success: function(response) {
                    if (response.status === 'success') {
                        calendar.refetchEvents();
                        $('#viewTask').modal('hide');
                    }
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    $('.toast').toast('show');
                    $('.toast .toast-body').text('An error occurred: ' + errorThrown);
                }
            });

        });


        $('#taskForm').on('submit', function(e) {
            e.preventDefault();
            let form = $(this);
            let method = $('#method').val();
            let url = method === 'POST' ? '{{ route('ajax.task.create') }}' : '{{ route('ajax.task.update') }}';
            let data = form.serialize();
            $.ajax({
                url: url,
                method: method,
                data: data,
                success: function(response) {
                    if (response.status === 'success') {
                        calendar.refetchEvents();
                        $('#task').modal('hide');
                    }
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    $('.toast').toast('show');
                    $('.toast .toast-body').text('An error occurred: ' + errorThrown);
                }
            });
        });
    });

    $(window).resize(function() {
        if (calendar === undefined) return;
        let currentView = calendar.view.type;
        let newView = $(window).width() < 765 ? "timeGridToday" : 'timeGridWeek';
        if (currentView !== newView) {
            calendar.changeView(newView);
        }
        if ($(window).width() < 765) {
            calendar.setOption('height', 'auto');
        } else {
            calendar.setOption('height', 650);
        }
    });

</script>