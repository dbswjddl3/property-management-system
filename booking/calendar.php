<?php
include_once "../header.php";
include_once "./modal.php";
?>

<h1 class="w3-border-bottom w3-border-light-grey w3-padding-16">Booking Calendars</h1>

<div id='calendar'></div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        $.ajax({
            url: 'db_calendar.php',
            type: 'POST',
            dataType: 'json',
            data: {
                mode: 'get_bookings',
                building: '<?=$_SESSION['building']?>'
            },
            success: function(data) {
                var calendarEl = document.getElementById('calendar');
                var calendar = new FullCalendar.Calendar(calendarEl, {
                    plugins: [ 'interaction', 'dayGrid', 'timeGrid' ],
                    selectable: true,
                    selectOverlap: true,
                    header: {
                        left: 'prev,next',
                        center: 'title',
                        right: 'dayGridMonth,timeGridWeek,timeGridDay'
                    },
                    defaultView: 'timeGridWeek',
                    defaultDate: new Date(),
                    displayEventTime: true,
                    editable: true,
                    eventLimit: true,
                    events: data,
                    longPressDelay: false,
                    navLinks: true,
                    eventTimeFormat: { 
                        hour: 'numeric',
                        minute: '2-digit',
                        meridiem: 'short'
                    },
                    select: function(info) {
                        modalToggle(info);
                    },
                    eventClick: function(info) {
                        modalToggle(info);
                    },
                    eventDrop: function(info) {
                        changeEventTime(info.event);
                    },
                    eventResize: function(info) {
                        changeEventTime(info.event);
                    }
                });
        
                calendar.render();
            },
            error: function(e) {
                alert('An error has occurred');
            },
        });
    });
</script>

<?php
include_once "../footer.php";
?>