@extends('layouts.application.main_wide')
@section('content')
    <h2>{{ $project->name }}</h2>
    <div class="row">
        <div class="col-lg-5">
            <div id="project-information" class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title"><i class="glyphicon glyphicon-globe"></i> Project Information</h3>
                </div>
                <div class="panel-body">
                    <div class="row">
                        <div class="col-xs-12">
                            <i class="text-muted">Address</i><br />
                            {{ $project->street }}<br/>
                            {{ $project->city }} {{ $project->state }}, {{ $project->zip }}
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xs-6">
                            <i class="text-muted">Project Status</i><br/>
                            {{ $project->status }}
                        </div>
                        <div class="col-xs-6">
                            <i class="text-muted">Project Type</i><br />
                            {{ $project->type }}
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xs-6">
                            <i class="text-muted">Project Size</i><br />
                            {{ $project->size }} {{ $project->size_unit }}
                        </div>
                        <div class="col-xs-6">
                            <i class="text-muted">Project Value</i><br />
                            ${{ number_format($project->value) }}
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xs-12">
                            <i class="text-muted">Description</i><br />
                            {{ $project->description }}
                        </div>
                    </div>
                </div>
            </div>{{-- /.panel --}}

            <div id="schedule" class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title"><i class="glyphicon glyphicon-time"></i> Schedule</h3>
                </div>
                <div class="panel-body">
                    <div class="pull-left">
                        <div class="text-muted">Start</div>
                        {{ $project->start }}
                    </div>
                    <div class="pull-right">
                        <div class="text-muted">Finish</div>
                        {{ $project->finish }}
                    </div>
                    <div class="progress">
                        <div class="progress-bar progress-bar-{{ $project->daysLeft < 0 ? "danger" : "info" }}" role="progressbar"
                             style="width: {{ $project->progress }}%;">
                            {{ $project->daysLeft }} Days
                        </div>
                    </div>
                </div>
            </div> {{-- /.panel --}}

            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title">
                        <i class="glyphicon glyphicon-question-sign"></i> Requests for Information
                    </h3>
                </div>
                <div class="panel-body">
                    <h3>In Progress</h3>
                </div>
            </div>{{-- /.panel --}}

            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title"><i class="glyphicon glyphicon-tags"></i> Submittals</h3>
                </div>
                <div class="panel-body">
                    <h3>In Progress</h3>
                </div>
            </div>{{-- /.panel --}}
        </div>
        <div class="col-lg-7">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title"><i class="glyphicon glyphicon-bullhorn"></i> Activity Feed</h3>
                </div>
                <div class="panel-body">
                    Activity Feed Goes Here
                </div>
            </div>
        </div>
    </div>
@endsection