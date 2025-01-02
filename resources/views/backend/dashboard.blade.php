@extends ('backend.layouts.app')
@section ('title', ('Dashboard'))
@section('page-header')
<h1>Dashboard</h1> 
@endsection
@section('content')
<div id="dashboard"> 
   <div class="row all-panels-row">
      <div class="col-lg-4 col-xs-6 col-md-6 col-sm-6 col-xs-12">
         <div class="small-box bg-aqua">
            <div class="inner">
               <h3>{{ $users??"0" }}</h3>
               <p>Active User</p>
            </div>
            <div class="icon">
               <i class="fa fa-users"></i>
            </div>
            <a href="access/user" class="small-box-footer">View Details<i class="fa fa-arrow-circle-right arrow-circle-r-icon"></i></a>
         </div>
      </div>

      <div class="col-lg-4 col-md-6 col-sm-6 col-xs-12">
         <div class="small-box bg-green">
            <div class="inner">
               <h3>{{ $businessUsers??"0" }}</h3>
               <p>Active Business User</p>
            </div>
            <div class="icon">
               <i class="fa fa-users"></i>
            </div>
            <a href="{{route('admin.access.business.index')}}" class="small-box-footer">View Details<i class="fa fa-arrow-circle-right arrow-circle-r-icon"></i></a>
         </div>
      </div>

      <div class="col-lg-4 col-md-6 col-sm-6 col-xs-12">
         <div class="small-box bg-purple">
            <div class="inner">
               <h3>{{ $adminUsers??"0" }}</h3>
               <p>Active Admin User</p>
            </div>
            <div class="icon">
               <i class="fa fa-users"></i>
            </div>
            <a href="{{route('admin.access.admin.index')}}" class="small-box-footer">View Details<i class="fa fa-arrow-circle-right arrow-circle-r-icon"></i></a>
         </div>
      </div>


      <div class="col-lg-4 col-md-6 col-sm-6 col-xs-12">
         <div class="small-box bg-primary">
            <div class="inner">
               <h3>{{ $deactivatedUsers??"0" }}</h3>

               <p>Total Block User</p>
            </div>
            <div class="icon">
               <i class="fa fa-ban"></i>
            </div>
            <a href="{{route('admin.access.user.deactivated')}}" class="small-box-footer">View Details<i class="fa fa-arrow-circle-right arrow-circle-r-icon"></i></a>
         </div>
      </div>
      <div class="col-lg-4 col-md-6 col-sm-6 col-xs-12">
         <div class="small-box bg-maroon">
            <div class="inner">
               <h3>{{ $deactivatedBusinessUsers??"0" }}</h3>

               <p>Total Block Business User</p>
            </div>
            <div class="icon">
               <i class="fa fa-ban"></i>
            </div>
            <a href="{{route('admin.access.business.deactivated')}}" class="small-box-footer">View Details<i class="fa fa-arrow-circle-right arrow-circle-r-icon"></i></a>
         </div>
      </div>
      <div class="col-lg-4 col-md-6 col-sm-6 col-xs-12">
         <div class="small-box bg-aqua">
            <div class="inner">
               <h3>{{ $deactivatedAdminUsers??"0" }}</h3>

               <p>Total Block Admin User</p>
            </div>
            <div class="icon">
               <i class="fa fa-ban"></i>
            </div>
            <a href="{{route('admin.access.admin.deactivated')}}" class="small-box-footer">View Details<i class="fa fa-arrow-circle-right arrow-circle-r-icon"></i></a>
         </div>
      </div>
       <!--property count-->
      <div class="col-lg-4 col-md-6 col-sm-6 col-xs-12">
         <!-- small box -->
         <div class="small-box bg-yellow">
            <div class="inner">
               @if(isset($rents))
               <h3>{{ $rents }}</h3>
               @else
               <h3></h3>
               @endif
               <p>Total Rent Listing</p>
            </div>
            <div class="icon">
               <i class="fa fa-home"></i>
            </div>
            <a href="rent" class="small-box-footer">View Details<i class="fa fa-arrow-circle-right arrow-circle-r-icon"></i></a>
         </div>
      </div>

      <div class="col-lg-4 col-md-6 col-sm-6 col-xs-12">
         <div class="small-box bg-olive">
            <div class="inner">
               @if(isset($sales))
               <h3>{{ $sales }}</h3>
               @else
               <h3></h3>
               @endif
               <p>Total Sale Listing</p>
            </div>
            <div class="icon">
               <i class="fa fa-home"></i>
            </div>
            <a href="sale" class="small-box-footer">View Details<i class="fa fa-arrow-circle-right arrow-circle-r-icon"></i></a>
         </div>
      </div>

      <div class="col-lg-4 col-md-6 col-sm-6 col-xs-12">
         <div class="small-box bg-red">
            <div class="inner">
               @if(isset($vacations))
               <h3>{{ $vacations }}</h3>
               @else
               <h3></h3>
               @endif
               <p>Total Vacation Listing</p>
            </div>
            <div class="icon">
               <i class="fa fa-spotify"></i>
            </div>
            <a href="vacation" class="small-box-footer">View Details<i class="fa fa-arrow-circle-right arrow-circle-r-icon"></i></a>
         </div>
      </div>
   </div>
</div>
@endsection


