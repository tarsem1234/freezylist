@extends ('backend.layouts.app')

@section ('title', 'Access Management')

@section('page-header')
<?php
$boxTitle = trans('labels.backend.access.users.view');
$headerLabel = trans('labels.backend.access.users.user_management');
$overViewtab = 'backend.access.show.tabs.user_overview';

if (count($user->roles) > 0) {
    if (in_array(config('constant.inverse_user_type.Administrator'), array_column($user->roles->toArray(), 'id'))) {
        $headerLabel = trans('labels.backend.access.users.admin_management');
        $boxTitle = 'View Admin';
        $overViewtab = 'backend.access.show.tabs.user_overview';
    } else if (in_array(config('constant.inverse_user_type.Business'), array_column($user->roles->toArray(), 'id'))) {
        $headerLabel = trans('labels.backend.access.users.business_management');
        $boxTitle = trans('labels.backend.access.users.business_view');
        $overViewtab = 'backend.access.show.tabs.user_overview';
    } elseif (in_array(config('constant.inverse_user_type.Support'), array_column($user->roles->toArray(), 'id'))) {
        $headerLabel = 'Support Management';
        $boxTitle = 'View Support';
        $overViewtab = 'backend.access.show.tabs.user_overview';
    }
}
?>

<h1> {{ $headerLabel }}</h1>
@endsection

@section('content')
<div class="box box-success">
    <div class="box-header with-border">
        <h3 class="box-title">{{ $boxTitle }}</h3>

        <div class="box-tools pull-right">
            @include('backend.access.includes.partials.user-header-buttons')
        </div><!--box-tools pull-right-->
    </div><!-- /.box-header -->

    <div class="box-body">

        <div role="tabpanel">

            <!-- Nav tabs -->
            <ul class="nav nav-tabs" role="tablist">
                <li role="presentation" class="active">
                    <a href="#overview" aria-controls="overview" role="tab" data-toggle="tab">{{ trans('labels.backend.access.users.tabs.titles.overview') }}</a>
                </li>

                <li role="presentation">
                    <a href="#history" aria-controls="history" role="tab" data-toggle="tab">{{ trans('labels.backend.access.users.tabs.titles.history') }}</a>
                </li>
            </ul>

            <div class="tab-content">

                <div role="tabpanel" class="tab-pane mt-30 active" id="overview">
                    @include($overViewtab)
                </div><!--tab overview profile-->

                <div role="tabpanel" class="tab-pane mt-30" id="history">
                    @include('backend.access.show.tabs.history')
                </div><!--tab panel history-->

            </div><!--tab content-->

        </div><!--tab panel-->

    </div><!-- /.box-body -->
</div><!--box-->
@endsection