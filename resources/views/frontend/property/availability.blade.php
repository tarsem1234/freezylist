@extends('frontend.layouts.app')
@section('title', app_name() . ' | Rent-Listings')
@section('after-styles')
<link type="text/css" rel="stylesheet" href="{{ asset(mix('css/dashboard.css')) }}" media="all">
<style>#rent-pages{ font-weight: bold;color: #000;}</style>
@endsection 
@section('content')
<div class="dashboard-page associates" id="calender-page">     
    <div class="container">
        <div class="row content"> 
            @include('frontend.includes.sidebar')
            <div class="col-md-9 col-sm-8" id="vue-page">
                <div class="right-dashboard-div">
                    <div class="right-dashboard-div-text">
                        <div class="row padding-space"> 
                            <div class="col-md-12 col-xs-12 col-sm-6 col-lg-6">
                                <h4>My Scheduled Availability</h4>
                            </div>
                            <div class="col-md-12">
                                {{ html()->form("POST", route('frontend.property.add_availability'))->open() }}
                                {{ html()->hidden('property_id', $property->id) }}
                                {{ html()->hidden('date') }}
                                <div class="table-responsive"><div id="calendar"></div></div> 
                                <div class="row mar-top"> 
                                    <div class="form-group col-md-6">
                                        <label class="form-label">Start Time</label>
                                        <select class="form-control" 
                                                @change="setEndTimes()" v-model='avl.start_time' name="start_time" required>
                                            <option value="">Select Start Time</option>
                                            <option 
                                                v-for="(time, index) in start_times" 
                                                v-bind:key="index"
                                                v-bind:value="time.time">@{{time.display}}</option>
                                        </select>
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label class="form-label">End Time</label>
                                        <select class="form-control" v-model='avl.end_time' name="end_time" required>
                                            <option value="">Select End Time</option>
                                            <option 
                                                v-for="(time, index) in end_times" 
                                                v-bind:key="index"
                                                v-bind:value="time.time">@{{time.display}}</option>
                                        </select>
                                    </div>
                                    <div class="col-lg-12">
                                        <div class="text-center btns-green-blue">
                                            <button class="btn button btn-green mar-top" type="submit">Add </button> 
                                        </div>
                                        <div class="availability-div"> 
                                            <div class="">
                                                <h4>Manage Availability</h4>
                                            </div>                          
                                            <div class="row"> 
                                                <div class="form-group col-md-6"> 
                                                    <label>Year</label>
                                                    <select class="form-control year-filter" name="selected-year" v-model="search.selectedYear" @change="refreshItems()">
                                                        <option v-for="year in years" v-bind:value="year">@{{year}}</option>
                                                    </select>
                                                </div>
                                                <div class="form-group col-md-6">
                                                    <label>Month</label>
                                                    <select class="form-control year-filter" name="selected-month" v-model="search.selectedMonth" @change="refreshItems()">
                                                        <option v-for="month in months" v-bind:value="month.key">@{{month.value}}</option>
                                                    </select>

                                                </div> <br>
                                                <div class="text-center">
                                                    <i class="fa fa-spin fa-spinner fa-2x" v-if="loadingItems"></i>
                                                </div>
                                                <div class="col-md-12">
                                                    <div class="table-responsive">  
                                                        <table class="table table-bordered avalability_table">
                                                            <thead>
                                                                <tr>
                                                                    <th>#</th>
                                                                    <th>Date</th>
                                                                    <th>Start Time</th>
                                                                    <th>End Time</th>
                                                                    <th>Action</th>
                                                                    <th>Accepted By</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody v-if="items.length > 0">
                                                                <tr v-for="(item, i) in items">
                                                                    <td>@{{i+1}}</td>
                                                                    <td>@{{item.date}}</td>
                                                                    <td>@{{formatTime(item.start_time)}}</td>
                                                                    <td>@{{formatTime(item.end_time)}}</td>
                                                                    <td>
                                                                        <a
                                                                            class="btn btn-danger btn-sm delete_avl" 
                                                                            v-bind:href="'{{url('property/delete_availability/')}}/'+item.id">
                                                                            <i class="fa fa-times"></i> Remove
                                                                        </a>
                                                                    </td>
                                                                    <td>
                                                                        <span v-if="!item.user_id">NA</span>
                                                                        <span v-else>@{{item.user.full_name}} (@{{item.user.email}})</span>
                                                                    </td>
                                                                </tr>
                                                            </tbody>
                                                            <tbody v-else>
                                                                <tr>
                                                                    <td colspan="6" class="no-data">No Records Found</td>
                                                                </tr>
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </div>
                                            </div> 
                                        </div>
                                        {{ html()->form()->close() }}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div><!--right-dashboard-div-->            
                </div><!--col-9-->
            </div><!--row--> 
        </div><!--container-->
    </div><!--row--> 
</div><!--container--> 
@endsection
@section('after-scripts')
<link href="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.9.0/fullcalendar.min.css" rel="stylesheet" type="text/css"/>
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.15.1/moment.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.9.0/fullcalendar.min.js"></script>
<script>
var items = <?= json_encode($property->availability->load('user')) ?>;
$(function () {
    $('select').select2();
    $('#calendar').fullCalendar({
        header: {
            left: 'title',
            right: 'prev,next'
        },
        selectable: true,
        selectLongPressDelay: 1,
        longPressDelay: 1,
        select: function (start, end, jsEvent) {
            $('.fc-day-top').removeClass('selectedEvent');
            if (moment().diff(start, 'days') > 0) {
                $('input[name=date]').val('');
                $('#calendar').fullCalendar('unselect');
                return false;
            } else {
                $(jsEvent.target).parent().addClass('selectedEvent');
                $('input[name=date]').val(start.format());
            }
        }
    });
});
var vueEl = new Vue({
    el: '#vue-page',
    data: {
        items: items, loadingItems: false,
        search: {selectedYear: "{{date('Y')}}", selectedMonth: "{{date('m')}}"},
        avl: {start_time: '', end_time: '', date: ''},
        start_times: [], end_times: [], years: [], months: []
    },
    methods: {
        times() {
            var times = [];
            var time = this.avl.start_time == '' ? moment().startOf('day') : moment(this.avl.start_time).add(30, 'm');
            var end = time.clone().endOf('day');
            while (time.isBefore(end)) {
                times.push({time: time.format(), display: time.format('h:mm a')});
                time.add(30, 'm');
            }
            return times;
        },
        setEndTimes() {
            this.avl.end_time = '';
            this.end_times = this.times();
            $('[name=end_time]').select2();
        },
        refreshItems() {
            this.loadingItems = true;
            var ref = this;
            axios.post("{{route('frontend.property.getAvailabilities')}}", {id: "{{$property->id}}", search: this.search}).then(function (res) {
                ref.loadingItems = false;
                ref.items = res.data.availability;
            });
        },
        formatTime(time) {
            return moment('2018-01-01 ' + time).format('hh:mm a');
        }
    },
    mounted() {
        this.start_times = this.times();
        for (var i = 2015; i <= 2025; i++)
            this.years.push(i);
        var startMonth = moment().startOf('year');
        for (var i = 1; i <= 12; i++) {
            this.months.push({key: startMonth.format('MM'), value: startMonth.format('MMMM')});
            startMonth.add(1, 'M');
        }
    }
});
$('[name=start_time]').on('select2:select', function (e) {
    $('[name=end_time]').select2('close');
    vueEl.avl.start_time = $(this).val();
    vueEl.setEndTimes();
});
$('.year-filter').on('select2:select', function (e) {
    if ($(this).attr('name') == 'selected-year')
        $('[name=selected-month]').val('01').trigger('change');
    vueEl.search.selectedYear = $('[name=selected-year]').val();
    vueEl.search.selectedMonth = $('[name=selected-month]').val();
    vueEl.refreshItems();
});
</script>
@endsection


