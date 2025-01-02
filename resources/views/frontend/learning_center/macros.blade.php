@extends('frontend.layouts.app')

@section('title', app_name() . ' | Macros')

@section('content')
    <div class="row">

        <div class="col-xs-12">

            <div class="panel panel-default">
                <div class="panel-heading"><i class="fa fa-home"></i> {{ trans('labels.frontend.macros.macro_examples') }}</div>

                <div class="panel-body">
                    <div class="form-group">
                        <label>{{ trans('labels.frontend.macros.state.us.us') }}</label>
                        {{-- Shorthand for this is just selectState, set which version is shorthanded in Macros/Dropdowns --}}
                        {{ html()->selectstateus('state', 'NY', ['class' => 'form-control']) }}
                    </div>
                    <div class="form-group">
                        <label>{{ trans('labels.frontend.macros.state.us.outlying') }}</label>
                        {{ html()->selectstateusoutlyingterritories('state_outlying', null, ['class' => 'form-control']) }}
                    </div>
                    <div class="form-group">
                        <label>{{ trans('labels.frontend.macros.state.us.armed') }}</label>
                        {{ html()->selectstateusarmedforces('armed_forces', null, ['class' => 'form-control']) }}
                    </div>
                    <div class="form-group">
                        <label>{{ trans('labels.frontend.macros.territories.canada') }}</label>
                        {{ html()->selectcanadaterritories('canada_territories', null, ['class' => 'form-control']) }}
                    </div>
                    <div class="form-group">
                        <label>{{ trans('labels.frontend.macros.state.mexico') }}</label>
                        {{ html()->selectstatemexico('mexico', null, ['class' => 'form-control']) }}
                    </div>
                    <div class="form-group">
                        <label>{{ trans('labels.frontend.macros.country.alpha') }}</label>
                        {{ html()->selectcountryalpha('country_alpha', 'ISO 3166-2:US', ['class' => 'form-control']) }}
                    </div>
                    <div class="form-group">
                        <label>{{ trans('labels.frontend.macros.country.alpha2') }}</label>
                        {{-- Shorthand for this is just selectCountry, set which version is shorthanded in Macros/Dropdowns --}}
                        {{ html()->selectcountryalpha2('country_alpha2', 'US', ['class' => 'form-control']) }}
                    </div>
                    <div class="form-group">
                        <label>{{ trans('labels.frontend.macros.country.alpha3') }}</label>
                        {{ html()->selectcountryalpha3('country_alpha3', 'USA', ['class' => 'form-control']) }}
                    </div>
                    <div class="form-group">
                        <label>{{ trans('labels.frontend.macros.country.numeric') }}</label>
                        {{ html()->selectcountrynumeric('country_numeric', '840', ['class' => 'form-control']) }}
                    </div>
                    <div class="form-group">
                        <label>{{ trans('labels.frontend.macros.timezone') }}</label>
                        {{ html()->selecttimezone('timezone', 'America/New_York', ['class' => 'form-control']) }}
                    </div>
                </div>
            </div><!-- panel -->

        </div><!-- col-md-10 -->

    </div><!-- row -->
@endsection