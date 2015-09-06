@extends('layouts.application.main_wide')
@extends('layouts.application.nav_project')
@section('content')
    <div class="page-wrapper">
        <div class="pagehead">
            <div class="container-fluid">
                @if(Session::get('projectUser')->access == \App\Models\Projectuser::ACCESS_ADMIN)
                    <a href="{!! URL::route('projects.edit', ['project' => $project->id]) !!}" class="btn btn-default pull-right btn-spacer-left"><i class="fa fa-pencil-square-o fa-fw"></i> Edit Project</a>
                @endif
                <h1>{!! '#' . $project->number . ' ' . $project->name !!}</h1>
                <p class="text-muted no-margin">Your project at a glance.</p>
            </div>
        </div>
      
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-6 col-lg-3">
                    <!-- Project Information -->
                    <div id="project-information" class="panel panel-default">
                        <div class="panel-heading">
                            <span class="glyphicon glyphicon-globe"></span><span class="btn-spacer-left">Project Information</span>
                        </div>
                        <div class="panel-body">
                            <div class="row">
                                <div class="col-xs-12">
                                    <span class="text-muted">Address</span><br/>
                                    {!! $project->street !!}<br/>
                                    {!! $project->city !!}, {!! $project->state !!} {!! $project->zip_code !!}<br/>
                                    {!! @$project->country !!}
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
                            <div class="row" style="padding-bottom:0;">
                                <div class="col-xs-12">
                                    <span class="text-muted">Description</span><br/>
                                    {!! $project->description !!}
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Schedule -->
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
                                     style="width:{!! $project->progress !!}%;">
                                    {!! abs($project->daysLeft) !!} Days {{ $project->daysLeft >= 0 ? 'Remaining' : 'Overdue' }}
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- RFIs -->
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <i class="fa fa-info-circle"></i><span class="btn-spacer-left">Requests for Information</span>
                        </div>
                        <div class="panel-body">
                            replacing table below with chart
                        </div>
                    </div>
                    
                    <!-- RFIs -->
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <i class="fa fa-info-circle"></i><span class="btn-spacer-left">Requests for Information</span>
                        </div>
                        <div class="panel-body">
                            <table class="table">
                                <thead>
                                    <th>ID</th>
                                    <th>Subject</th>
                                    <th>Assigned To</th>
                                    <th>Due Date</th>
                                    <th></th>
                                </thead>
                                <tbody>
                                    @foreach($project->rfis as $rfi)
                                        <tr>
                                            <td>{{ $rfi->rfi_id }}</td>
                                            <td>{{ $rfi->subject }}</td>
                                            <td>
                                                <img src="{{ $rfi->assignedTo->gravatar }}" class="avatar_sm img-circle"/>
                                                {{ $rfi->assignedTo->name }}
                                            </td>
                                            <td>{{ $rfi->due_date }}</td>
                                            <td>{!! link_to_route('rfis.show', 'View', ['rfis' => $rfi->id], ['class' => 'btn btn-default btn-sm']) !!}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                
                <div class="col-md-6 col-lg-4 col-lg-push-5">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <span class="glyphicon glyphicon-bullhorn"></span><span class="btn-spacer-left">Activity Feed</span>
                        </div>
                        <div class="panel-body">
                            Activity Feed Goes Here
                        </div>
                    </div>
                </div>
                
                <div class="col-md-6 col-lg-5 col-lg-pull-4">
                    <!-- Weather -->
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <i class="wi wi-day-cloudy-gusts"></i><span class="btn-spacer-left">Weather</span>
                        </div>
                        <div class="panel-body" style="padding:5px 15px;">
                            <iframe id="forecast_embed" type="text/html" frameborder="0" height="245" width="100%" src="http://forecast.io/embed/#lat={!! $location->latitude() !!}&lon={!! $location->longitude() !!}&name={!! $project->city !!}"> </iframe>
                        </div>
                    </div>
                    
                    <!-- Manpower -->
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <i class="fa fa-users"></i><span class="btn-spacer-left">Manpower</span>
                        </div>
                        <div class="panel-body" style="padding:5px;">
                            <div style="padding:10px 10px 0 10px;">
                                <?php
                                    $crewHours = 0;
                                    $manHours = 0;
                                    foreach($dcrs as $dcr) {
                                        $crewHours += $dcr->crewhours;
                                        $manHours += $dcr->manhours;
                                    }
                                ?>
                                <p>
                                    <span class="bold">Total Crew Hours:</span> {!! number_format($crewHours) !!}
                                    <span class="bold btn-spacer-left">Total Man Hours:</span> {!! number_format($manHours) !!}
                                </p>
                            </div>
                            <div id="dcrChart" style="height:250px;">
                                <script type="text/javascript">
                                    new Morris.Line({
                                      element: 'dcrChart',
                                      data: [
                                        <?php
                                            foreach($dcrs as $dcr) {
                                                echo '{ week: \'' . date('Y-m-d', strtotime($dcr->date))  . '\', crew: ' . $dcr->crew . ', hours: ' . $dcr->crewhours . ' },';
                                            }
                                        ?>
                                      ],
                                      // The name of the data record attribute that contains x-values.
                                      xkey: 'week',
                                      // A list of names of data record attributes that contain y-values.
                                      ykeys: ['crew', 'hours'],
                                      // Labels for the ykeys -- will be displayed when you hover over the
                                      // chart.
                                      labels: ['Crew', 'Crew Hrs']
                                    });
                                </script>
                            </div>
                        </div>
                    </div>         
                </div>
                
                <!-- Submittals -->
                <!--
                <div class="col-md-6 col-lg-4">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <span class="glyphicon glyphicon-tags"></span><span class="btn-spacer-left">Submittals</span>
                        </div>
                        <div class="panel-body">
                            <h4>In Progress</h4>
                        </div>
                    </div>
                    -->
                </div>
            </div>
        </div>
    </div>
@endsection