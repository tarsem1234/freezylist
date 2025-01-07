@extends('frontend.layouts.app')
@section('title', app_name() . ' | Rent-Listings')
@section('after-styles')
<link type="text/css" rel="stylesheet" href="{{ asset(mix('css/dashboard.css')) }}" media="all">
<link type="text/css" rel="stylesheet" href="{{ asset(mix('css/common.css')) }}" media="all">
<style>#rent-pages{ font-weight: bold;color: #000;}</style>
@endsection 
@section('content')
<div class="dashboard-page associates profile-view" id="calender-page">    
    <div class="container">
        <div class="row content"> 
            @include('frontend.includes.sidebar')
            <div class="col-md-9 col-sm-8" id="vue-page">
                <div class="right-dashboard-div">
                    <div class="right-dashboard-div-text">
                        <div class="row padding-space"> 
                            <div class="col-md-12 col-xs-12 col-sm-6 col-lg-6">
                                <h4>Set Availability</h4>
                            </div>
                            <div class="col-md-12 btns-green-blue">
                                <p>Following are the availability calendar for your vacation listing. You can set the availability by clicking on multiple dates. To remove or edit the availability you can click on the highlighted dates. </p>
                                <div id="calendar"></div>

                                <button type="button" class="btn btn-lg btn-green button" id="select-all">Select All</button>
                                <button type="button" class="btn btn-lg btn-blue button" id="unselect-all">Unselect All</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div><!--right-dashboard-div-->           
        </div><!--col-9-->
    </div><!--row-->
</div><!--container-->
@endsection
@section('after-scripts')
<link href="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.9.0/fullcalendar.min.css" rel="stylesheet" type="text/css"/>
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.15.1/moment.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.9.0/fullcalendar.min.js"></script>
<script>
var selectedMonth;
var updateSelectedEventsCount = 0;
$(function () {

    var events = <?= $property->availabilities->pluck('start_date') ?>;
    $('#calendar').fullCalendar({
        header: {
            left: 'title',
            right: 'prev,next today'
        },
        selectable: true,
        select: function (start, end, jsEvent, view) {
            $(jsEvent.target).parent().toggleClass('selectedEvent');
            if ($(jsEvent.target).parent().hasClass('selectedEvent'))
                updateEvents('push', start);
            else
                updateEvents('pop', start);
            $('#calendar').fullCalendar('unselect');
        },
        eventAfterAllRender() {
            updateSelectedEvents();
        },
        viewRender(e, v) {
//            console.log(e.intervalStart.format('M'));
//            console.log(e.intervalStart.format('Y'));
            date = e.intervalStart.format('YYYY-MM-DD');
            type = 'all';
            renderSelectedDays(date, type);
//            updateSelectedEvents();
        }
    });
    function renderSelectedDays(dt, type){
        $.ajax({
            url: "{{route('frontend.getVacationAvailability', $property->id)}}",
            success(response) {
                events = response;
                updateSelectedEventsCount = 0;
                updateSelectedEvents();
            },
            error() {
                $('.fc-center').text('Something went wrong. Please try again').addClass('text text-danger');

            }
        });
    }
    $('.fc-button').on('click', function () {
        updateEvents('next', );
    });
    $('#select-all').on('click', function () {
        $('#calendar').find('td').not('.fc-other-month').addClass('selectedEvent');
        selectedMonth = $('.fc-day-top.selectedEvent').data('date');
        updateEvents('all', 'select');
    });
    $('#unselect-all').on('click', function () {
        selectedMonth = $('.fc-day-top.selectedEvent:first').data('date');
        $('#calendar').find('.selectedEvent').removeClass('selectedEvent');
        if (selectedMonth) {
            updateEvents('all', 'unselect');
        }
    });
    function updateSelectedEvents() {
        if (updateSelectedEventsCount == 0) {
            updateSelectedEventsCount++
            $.each(events, function (i, v) {
                $('[data-date=' + v + ']').addClass('selectedEvent');
            });
        }
    }
    function updateEvents(type = 'all', dt) {
        if (type != 'all' && type != 'next')
            dt = dt.format('Y-MM-DD');
        var type;
        if (type == 'push') {
            type = 'add';
            events.push(dt);
        } else if (type == 'pop') {
            $('.fc-center').addClass('text text-success').text('Availability Removed');
            events = $.grep(events, function (value) {
                return value != dt;
            });
        } else if (type == 'all') {
            type = dt;
            dt = selectedMonth;
        }
        updateSelectedEvents();
        $.ajax({
            url: "{{route('frontend.updateVacationDates', $property->id)}}",
            method: "POST",
            data: {date: dt, type: type},
            success(response) {
                $('.fc-center').removeClass().addClass('fc-center');
                if (response.status == true)
                    $('.fc-center').addClass('text text-success');
                else
                    $('.fc-center').text('Something went wrong. Please try again').addClass('text text-danger');
                if(type == 'next'){
                    $('.fc-center').css('display','none');
                } else if(type == 'add' || type == 'select'){
                    $('.fc-center').css('display','block');
                    $('.fc-center').text('Availability Added');
                }
                else{
                    $('.fc-center').css('display','block');
                   $('.fc-center').text('Availability Removed');
                }
            },
            error() {
                $('.fc-center').text('Something went wrong. Please try again').addClass('text text-danger');
            }
        });
    }
});
</script>
@endsection


