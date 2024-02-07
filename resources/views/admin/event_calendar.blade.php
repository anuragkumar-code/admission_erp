@extends('admin.layout.head')
@section('admin')


<link rel="stylesheet" href="{{asset('admin/event_calendar/fonts/icomoon/style.css')}}">  
<link href="{{asset('admin/event_calendar/fullcalendar/packages/core/main.css')}}" rel='stylesheet' />
<link href="{{asset('admin/event_calendar/fullcalendar/packages/daygrid/main.css')}}" rel='stylesheet' />    
<!-- Bootstrap CSS -->
<link rel="stylesheet" href="{{asset('admin/event_calendar/css/bootstrap.min.css')}}">   
<!-- Style -->
<link rel="stylesheet" href="{{asset('admin/event_calendar/css/style.css')}}">



<div class="content-wrap">
    <div class="main">

             <div class="container-fluid">
            <div class="row">
             <!--    <div class="headertopcontent">          
            <a href="{{url('admin/add_event')}}" class="btn btn-outline-primary addnewstaffbtn rightbtns">+ Add New Event</a>
        </div> -->
    </div>

            <div class="row">  

                <!-- <div class="contentinner">              
                    <div id='calendar-container'>
                        <div id='calendar'></div>
                    </div>
                    </div> -->


                   <!-- <iframe src="https://calendar.google.com/calendar/embed?height=600&wkst=1&bgcolor=%23ffffff&ctz=Asia%2FKolkata&src=c2F0eWVuZHJhLmFycmpAZ21haWwuY29t&src=YWRkcmVzc2Jvb2sjY29udGFjdHNAZ3JvdXAudi5jYWxlbmRhci5nb29nbGUuY29t&src=ZW4tZ2IuaW5kaWFuI2hvbGlkYXlAZ3JvdXAudi5jYWxlbmRhci5nb29nbGUuY29t&color=%23039BE5&color=%2333B679&color=%230B8043" style="border:solid 1px #777" width="800" height="600" frameborder="0" scrolling="no"></iframe> -->


                   <iframe src="https://calendar.google.com/calendar/embed?height=600&wkst=1&bgcolor=%23ffffff&ctz=Australia%2FSydney&src=Zm9sbG93dXBAcm95YWxtaWdyYXRpb24uY29tLmF1&src=YWRkcmVzc2Jvb2sjY29udGFjdHNAZ3JvdXAudi5jYWxlbmRhci5nb29nbGUuY29t&src=ZW4uYXVzdHJhbGlhbiNob2xpZGF5QGdyb3VwLnYuY2FsZW5kYXIuZ29vZ2xlLmNvbQ&src=ZW4uaW5kaWFuI2hvbGlkYXlAZ3JvdXAudi5jYWxlbmRhci5nb29nbGUuY29t&color=%23039BE5&color=%2333B679&color=%234285F4&color=%230B8043" style="border:solid 1px #777" width="800" height="600" frameborder="0" scrolling="no"></iframe>


                </div>
            </div>
        </div>
    </div>



<script src="{{asset('admin/event_calendar/fullcalendar/packages/core/main.js')}}"></script>
    <script src="{{asset('admin/event_calendar/fullcalendar/packages/interaction/main.js')}}"></script>
    <script src="{{asset('admin/event_calendar/fullcalendar/packages/daygrid/main.js')}}"></script>
    <script src="{{asset('admin/event_calendar/fullcalendar/packages/timegrid/main.js')}}"></script>
    <script src="{{asset('admin/event_calendar/fullcalendar/packages/list/main.js')}}"></script>

<script>
      document.addEventListener('DOMContentLoaded', function() {
    var calendarEl = document.getElementById('calendar');

    var calendar = new FullCalendar.Calendar(calendarEl, {
      plugins: [ 'interaction', 'dayGrid', 'timeGrid', 'list' ],
      height: 'parent',
      header: {
        left: 'prev,next today',
        center: 'title',
        right: 'dayGridMonth,listWeek'
      },
      defaultView: 'dayGridMonth',
      defaultDate: '<?php echo date('Y-m-d'); ?>',
      navLinks: true, // can click day/week names to navigate views
      editable: true,
      eventLimit: true, // allow "more" link when too many events
      events: [
        <?php if($event_list){
            foreach ($event_list as $key => $event_list_val)
            {
                $end_date = date('Y-m-d', strtotime($event_list_val->end_date . ' +1 day'));
                $start_date = date('Y-m-d', strtotime($event_list_val->start_date . ' +1 day'));
            ?>
            {
                title: '<?php echo $event_list_val->event_title; ?>',
                start: '<?php echo $start_date; ?>',
                end: '<?php echo $end_date; ?>',
            },
            <?php    // code...
            }
        } ?>
                
      ]
    });

    calendar.render();
  });

    </script>

    <script src="js/main.js"></script>


<style type="text/css">
    
    .fc-scroller .fc-day-grid-container
    {

    overflow: inherit !important;
    height: auto !important;

    }

    .headertopcontent a {
    color: #fff;
}

button.btn.btn-outline-info.searchbtnsinto {
    color: #fff;
}
</style>
    @endsection