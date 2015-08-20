@extends('layouts.application.main_wide')
@extends('layouts.application.nav_project')
@section('content')
  <div class="page-wrapper">
    <div class="container-fluid">
        <div class="pagehead">
            <a href="#" class="btn btn-default pull-right btn-spacer-left mobile-hide" title="Print"><i class="fa fa-print"></i> Print</a>
            <a href="#" class="btn btn-default pull-right btn-spacer-left mobile-hide">Next <i class="fa fa-arrow-circle-right"></i></a>
            <a href="#" class="btn btn-default pull-right mobile-hide"><i class="fa fa-arrow-circle-left"></i> Previous</a>
            <h1>Daily Construction Report</h1>
        </div>
        
        <div class="form-horizontal">
            <!-- Date -->
            <div class="form-group">
                {!! Form::label('date', 'Report Date', array('class' => 'col-sm-3 col-md-2 control-label')) !!}
                <div class="col-sm-9 col-md-10">
                    <p class="form-control-static">{!! date('l M d, Y', strtotime($dcr->date)) !!}</p>
                </div>
            </div>

            <!-- Weather -->
            <div class="form-group">
                {!! Form::label('weather', 'Weather', array('class' => 'col-sm-3 col-md-2 control-label')) !!}
                <div class="col-sm-9 col-md-10">
                    <p class="form-control-static">{!! $dcr->weather . ' ' . $dcr->temperature . '&deg; ' . $dcr->temperature_type[0] !!}</p>
                </div>
            </div>

            <!-- Comments -->
            <div class="form-group">
                {!! Form::label('comments', 'Comments', array('class' => 'col-sm-3 col-md-2 control-label')) !!}
                <div class="col-sm-9 col-md-10">
                    <p class="form-control-static">{!! nl2br($dcr->comments) !!}</p>
                </div>
            </div>

            <!-- Correspondence -->
            <div class="form-group">
                {!! Form::label('correspondence', 'Correspondence', array('class' => 'col-sm-3 col-md-2 control-label')) !!}
                <div class="col-sm-9 col-md-10">
                    <p class="form-control-static">{!! nl2br($dcr->correspondence) !!}</p>
                </div>
            </div>

            <!-- Critical Issues -->
            <div class="form-group">
                {!! Form::label('issues', 'Critical Issues', array('class' => 'col-sm-3 col-md-2 control-label')) !!}
                <div class="col-sm-9 col-md-10">
                    <p class="form-control-static">{!! nl2br($dcr->issues) !!}</p>
                </div>
            </div>

            <!-- Safety -->
            <div class="form-group">
                {!! Form::label('safety', 'Saftey', array('class' => 'col-sm-3 col-md-2 control-label')) !!}
                <div class="col-sm-9 col-md-10">
                    <p class="form-control-static">{!! nl2br($dcr->safety) !!}</p>
                </div>
            </div>
            
            <!-- Buttons -->
            <div class="form-group no-margin">
                <div class="col-sm-10 col-sm-offset-2">
                    <a href="{!! '/dcrs/' . $dcr->id . '/edit' !!}" class="btn btn-info"><i class="fa fa-pencil"></i> Edit</a>
                </div>
            </div>
        </div>
    </div>
  </div>
@endsection
