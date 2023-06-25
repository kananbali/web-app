<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/fullcalendar@5.10.2/main.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
    <title>Document</title>
</head>

<body onload="getevents()">
    <div id='calendar'></div>
    <script src="https://cdn.jsdelivr.net/npm/fullcalendar@5.10.2/main.min.js"></script>
    <script>
        function getevents() {
            $.ajax({
                url: 'getevents.php',
                type: 'GET',
                success: function(data) {
                    // console.log(data);
                    var events = JSON.parse(data);
                    // console.log(events);
                    var calenderarr = [];
                    for (i = 0; i < events.length; i++) {
                        var title = events[i].event_name;
                        var id = events[i].event_id;
                        var st = Date.parse(events[i].event_date + 'T' + events[i].event_start_time);
                        var et = Date.parse(events[i].event_date + 'T' + events[i].event_end_time);
                        let arr = {
                            title: title,
                            start: st,
                            end: et,
                            id: id,
                            // color:'red'
                        };
                        calenderarr.push(arr);
                    }
                    // console.log(calenderarr);
                    var calendarEl = document.getElementById('calendar');
                    var calendar = new FullCalendar.Calendar(calendarEl, {
                        headerToolbar: {
                            left: 'prev,next today',
                            center: 'title',
                            right: 'dayGridMonth,timeGridWeek'
                        },
                        events: calenderarr,
                        handleWindowResize: true,
                        stickyHeaderDates: true,
                        expandRows: true,
                        height: 'auto',
                        themeSystem: 'flaty',
                        eventClick: function(info) {
                            console.log(info);
                            window.location.href = "../event/index.php?eventid=" + info.event.id;
                        }
                    });
                    calendar.render();
                }
            });
        }
    </script>
    <style>
        .fc-col-header-cell-cushion {
            color: #012970;
        }

        .fc-daygrid-day-number {
            color: #012970;
        }
    </style>
</body>

</html>