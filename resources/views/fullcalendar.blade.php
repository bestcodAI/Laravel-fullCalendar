<!Doctye html>
<html>
 <head>
     <title>FullCalendar in larvel developing by mrr chamnan</title>
     <meta name="csrf-token" content="{{ csrf_token() }}">
     <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" />
     <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
     <!-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.9.0/fullcalendar.css" /> -->
     <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.24.0/moment.min.js"></script>
     <!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.9.0/fullcalendar.js"></script> -->
     <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
     <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css" />
     @vite('resources/js/app.js')
     @vite('resources/css/fullcalendar.css')
     @vite('resources/js/fullcalendar.js')
 </head>
<body>
    <div class="container">
        <div class="jumbotron">
            <div class="container text-center">
                <h1 class="text-primary">Calendar Activity Everyday!&#128151;</h1>
                <h5 class="text-secondary">Make by: chamanan &#128512;</h5>
            </div>
        </div>
        <div id="calendar"></div>
    </div>
<script>
    $(document).ready(function (){

        var SITEURL = "{{ url('/') }}";

        $.ajaxSetup({
           headers: {
               'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
           }
        });

        var calendar = $('#calendar').fullCalendar({
            editable: true,
            events: SITEURL + "/fullcalendar",
            displayEventTime: true,
            editable: true,
            eventRender: function (event, element, view){
                if(event.allDay == true){
                    event.allDay = true;
                }
                else {
                    event.allDay = false;
                }
            },
            selectable: true,
            selectHelper: true,
            select: function(start, end, allDay){
                var title = prompt('Event Title: ');
                if(title){
                    var start = $.fullCalendar.formatDate(start,"YYYY-MM-DD");
                    var end = $.fullCalendar.formatDate(end,"YYYY-MM-DD");
                    $.ajax({
                        url: SITEURL + "/fullcalendarAjax",
                        data: {
                            title: title,
                            start: start,
                            end: end,
                            type: 'add'
                        },
                        type: "POST",
                        success: function(data){
                            displayMessage("Event Created Successfully! &#128525;");

                            calendar.fullCalendar('renderEvent',{
                                id: data.id,
                                title: title,
                                start: start,
                                end: end,
                                allDayf: allDay
                            }, true);

                            calendar.fullCalendar('unselect');
                        }
                    });
                }
            },
            eventDrop: function (event, data){
                var start = $.fullCalendar.formatDate(event.start, "YYYY-MM-DD");
                var end = $.fullCalendar.formatDate(event.end, "YYYY-MM-DD");

                $.ajax({
                  url: SITEURL + '/fullcalendarAjax',
                  data: {
                      title: event.title,
                      start: start,
                      end: end,
                      id: event.id,
                      type: 'edit'
                  },
                  type: "POST",
                  success: function (response){
                      displayMessage("Event Updated Successfully! &#128512;");
                  }
                });
            },
            eventClick: function (event){
                var deleteMsg = confirm("Do you really want to delete ?");
                if(deleteMsg){
                    $.ajax({
                       type: "POST",
                       url: SITEURL + '/fullcalendarAjax',
                        data: {
                           id: event.id,
                            type: 'destroy'
                        },
                        success: function (response){
                           calendar.fullCalendar('removeEvents', event.id);
                           displayMessage("Event Deleted Successfully! &#128549;");
                        }
                    });
                }
            }
        });
    });
    function displayMessage(message){
        toastr.success(message, 'Event Today');
    }
</script>
</body>
</html>
