@extends('layouts.application.main_wide')
@extends('layouts.application.nav_project')
@section('content')
    <div class="page-wrapper">
        <div class="pagehead">
            <div class="container-fluid">
                <span class="btn btn-primary pull-left toggle-nav" style="margin-right:10px;padding:7px;" onClick="$('#projectnav').toggle();"><span class="glyphicon glyphicon-menu-hamburger"></span></span>
                <h1>{!! '#' . $project->number . ' ' . $project->name !!}</h1>
                <p class="text-muted no-margin">Your project at a glance.</p>
            </div>
        </div>
      
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-5">
                    <div id="project-information" class="panel panel-default">
                        <div class="panel-heading">
                            <span class="glyphicon glyphicon-globe"></span><span class="btn-spacer-left">Project Information</span>
                        </div>
                        <div class="panel-body">
                            <div class="row">
                                <div class="col-xs-12">
                                    <span class="text-muted">Address</span><br/>
                                    {!! $project->street !!}<br/>
                                    {!! $project->city !!} {!! $project->state !!}, {!! $project->zip !!}
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-xs-6">
                                    <span class="text-muted">Project Status</span><br/>
                                    {!! $project->status !!}
                                </div>
                                <div class="col-xs-6">
                                    <span class="text-muted">Project Type</span><br/>
                                    {!! $project->type !!}
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-xs-6">
                                    <span class="text-muted">Project Size</span><br/>
                                    {!! $project->size ? number_format($project->size, 0, '.', ',') . ' ' . $project->size_unit : 'N/A' !!}
                                </div>
                                <div class="col-xs-6">
                                    <span class="text-muted">Project Value</span><br/>
                                    {!! $project->value ? '$' . number_format($project->value, 0, '.', ',') : 'N/A' !!}
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-xs-12">
                                    <span class="text-muted">Description</span><br/>
                                    {!! $project->description !!}
                                </div>
                            </div>
                        </div>
                    </div>{{-- /.panel --}}

                    <div id="schedule" class="panel panel-default">
                        <div class="panel-heading">
                            <span class="glyphicon glyphicon-time"></span><span class="btn-spacer-left">Schedule</span>
                        </div>
                        <div class="panel-body">
                            <div class="pull-left">
                                <div class="text-muted small">Start</div>
                                {!! $project->start !!}
                            </div>
                            <div class="pull-right" style="text-align:right;">
                                <div class="text-muted small">Finish</div>
                                {!! $project->finish !!}
                            </div>
                            <div class="progress">
                                <div class="progress-bar progress-bar-{!! $project->daysLeft < 0 ? "danger" : "info" !!}" role="progressbar"
                                     style="width: {!! $project->progress !!}%;">
                                    {!! abs($project->daysLeft) !!} Days {{ $project->daysLeft > 0 ? 'Left' : 'Overdue' }}
                                </div>
                            </div>
                        </div>
                    </div> {{-- /.panel --}}

                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <span class="glyphicon glyphicon-question-sign"></span><span class="btn-spacer-left">Requests for Information</span>
                        </div>
                        <div class="panel-body">
                            <h4>In Progress</h4>
                        </div>
                    </div>{{-- /.panel --}}

                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <span class="glyphicon glyphicon-tags"></span><span class="btn-spacer-left">Submittals</span>
                        </div>
                        <div class="panel-body">
                            <h4>In Progress</h4>
                        </div>
                    </div>{{-- /.panel --}}
                </div>
                <div class="col-lg-7">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <span class="glyphicon glyphicon-bullhorn"></span><span class="btn-spacer-left">Activity Feed</span>
                        </div>
                        <div class="panel-body">
                            Activity Feed Goes Here
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection