@extends('layouts.application.main_wide')
@extends('layouts.application.nav_project')
@section('content')
    <div class="page-wrapper">
        <div class="pagehead">
            <div class="container-fluid">
                <h1>RFI # {{ $rfi->rfi_id }} - {{ $rfi->subject }}</h1>
            </div>
        </div>
        <div class="container-fluid">
            <div class="panel panel-default">
                <div class="panel-body">
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-sm-2"><strong>Date</strong></div>
                            <div class="col-sm-4">{{ $rfi->created_at }}</div>
                        </div>
                        <div class="row">
                            <div class="col-sm-2"><strong>Assigned To</strong></div>
                            <div class="col-sm-4">{!! link_to('mailto:'. $rfi->assignedTo->email, $rfi->assignedTo->name) !!}</div>
                        </div>
                        <div class="row">
                            <div class="col-sm-2"><strong>Submitted To</strong></div>
                            <div class="col-sm-4">
                                <address>
                                    {{ $rfi->project->name }}<br />
                                    {{ $rfi->project->street }}<br />
                                    {{ $rfi->project->city }}, {{ $rfi->project->state }} {{ $rfi->project->zip_code }}
                                </address>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-2"><strong>Respond By</strong></div>
                            <div class="col-sm-4">{{ $rfi->due_date }}</div>
                            <div class="col-sm-2"><strong>Direct Response To</strong></div>
                            <div class="col-sm-4">{!! link_to('mailto:'. $rfi->createdBy->email, $rfi->createdBy->name) !!}</div>
                        </div>
                        <div class="row">
                            <div class="col-sm-2"><strong>Reference</strong></div>
                            <div class="col-sm-4">{{ $rfi->references }}</div>
                            <div class="col-sm-2"><strong>Cost Impact</strong></div>
                            <div class="col-sm-4">{{ $rfi->cost_impact }}</div>
                        </div>
                        <div class="row">
                            <div class="col-sm-2"><strong>Originated From</strong></div>
                            <div class="col-sm-4">{{ $rfi->origin }}</div>
                            <div class="col-sm-2"><strong>Schedule Impact</strong></div>
                            <div class="col-sm-4">{{ $rfi->schedule_impact }}</div>
                        </div>
                        <div class="row">
                            <div class="col-sm-2"><strong>Subject</strong></div>
                            <div class="col-sm-4">{{ $rfi->subject }}</div>
                        </div>
                        <div class="row">
                            <div class="col-sm-2"><strong>Question</strong></div>
                            <div class="col-sm-4">{{ $rfi->question }}</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection