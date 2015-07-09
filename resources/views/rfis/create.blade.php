@extends('layouts.application.main_wide')
@extends('layouts.application.nav_project')
@section('content')
    
    <script type="text/javascript" src="{!! asset('/js/jquery.currency.js') !!}"></script>
    <script type="text/javascript">
        $(document).ready(function(){
             //Date selector
             $("#date_due").datepicker({
                 changeMonth: true,
                 changeYear: true
             });
             // Currency format
             $('#cost_impact_qty').blur(function () {
                $('#cost_impact_qty').currency({decimals: 2});
            });
        });
    </script>
    
    <div class="page-wrapper">
        <div class="pagehead">
            <div class="container-fluid">
                <h1>Create a New RFI</h1>
            </div>
        </div>
        <div class="container-fluid">
            {!! Form::open(array('url'=>'rfis', 'method'=>'post', 'class'=>'form-horizontal')) !!}
            <div class="row">
                <div class="col-lg-3">
                    <div class="panel panel-default">
                        <div class="panel-heading">Basic Information</div>
                        <div class="panel-body">
                            <!-- Assign To -->
                            <div class="form-group">
                                <div class="col-sm-12">
                                    {!! Form::label('assign_to', 'Assign To', array('class' => 'control-label', 'style'=>'padding:0;')) !!}
                                    <div class="btn-group" style="width:100%;">
                                        <button class="btn btn-default btn-block" data-toggle="dropdown" style="text-align:left;padding:6px 11px;">
                                            Select a Collaborator <span class="caret"></span>
                                        </button>
                                        <ul class="dropdown-menu" role="menu" style="width:100%;">
                                            <!-- List Collaborators -->
                                            @foreach($collaborators as $collaborator)
                                                <li>
                                                    <a href="#" onClick="$('#assign_to').val('');">
                                                        <img src="{{ $collaborator->user->gravatar }}" class="avatar_sm"/>
                                                        {{ $collaborator->user->name }}<br>
                                                        <span class="small text-muted">{{ $collaborator->user->company->name }}</span>
                                                    </a>
                                                </li>
                                            @endforeach
                                            <li class="divider"></li>
                                            <li><a href="/collaborators/add" data-target="#modal" data-toggle="modal"><span class="glyphicon glyphicon-plus"></span> Add a Collaborator</a></li>
                                        </ul>
                                    </div>
                                    {!! Form::hidden('assign_to', null, array('required'=>'true' )) !!}
                                    <span class="text-danger">{!! $errors->first('assign_to') !!}</span>
                                    <div class="checkbox">
                                        <label>
                                            <input type="checkbox" name="assign_to_default" checked> <span class="text-muted">Set as default</span>
                                        </label>
                                    </div>
                                </div>
                            </div>

                            <!-- Distribution (Question & Responses) -->
                            <div class="form-group">
                                <div class="col-sm-12">
                                    {!! Form::label('distribution', 'Distribution', array('class' => 'control-label', 'style'=>'padding:0;')) !!}
                                    {!! Form::text('distribution', null, array('class' => 'form-control', 'placeholder' => 'Search by name or email...' )) !!}
                                    <span class="text-danger">{!! $errors->first('distribution') !!}</span>
                                </div>
                            </div>

                            <!-- Date Due -->
                            <div class="form-group">
                                <div class="col-sm-12">
                                    {!! Form::label('date_due', 'Due Date', array('class' => 'control-label', 'style'=>'padding:0;')) !!}
                                    {!! Form::text('date_due', null, array('class' => 'form-control', 'placeholder' => 'Select Date...', 'required'=>'true' )) !!}
                                    <span class="text-danger">{!! $errors->first('date_due') !!}</span>
                                    <!-- Priority -->
                                    <label class="radio-inline text-muted no-padding">Priority:</label>
                                    <label class="radio-inline text-danger"><input type="radio" name="priority" value="3"> High</label>
                                    <label class="radio-inline text-warning"><input type="radio" name="priority" value="2" checked> Medium</label>
                                    <label class="radio-inline text-info"><input type="radio" name="priority" value="1"> Low</label>
                                </div>
                            </div>

                            <!-- Origin -->
                            <div class="form-group">
                                <div class="col-sm-12">
                                    {!! Form::label('origin', 'Originated From', array('class' => 'control-label', 'style'=>'padding:0;')) !!}
                                    {!! Form::text('origin', null, array('class' => 'form-control', 'placeholder' => 'Ex. AC Const. RFI-001...', 'required'=>'true' )) !!}
                                    <span class="text-danger">{!! $errors->first('origin') !!}</span>
                                </div>
                            </div>

                            <!-- Schedule Impact -->
                            <div class="form-group">
                                <div class="col-sm-12">
                                    {!! Form::label('schedule_impact', 'Schedule Impact', array('class' => 'control-label', 'style'=>'padding:0;')) !!}
                                    <div class="btn-group" style="width:100%;">
                                        <button class="btn btn-default btn-block" data-toggle="dropdown" style="text-align:left;padding:6px 11px;">
                                            <span id="schedule_text">No</span> <span class="caret"></span>
                                        </button>
                                        <ul class="dropdown-menu" role="menu" style="width:100%;">
                                            <li><a href="#" onClick="$('#schedule').show();$('#schedule_text').html('Yes');$('#schedule_impact_qty').val('');$('#schedule_impact_qty').focus();">Yes</a></li>
                                            <li><a href="#" onClick="$('#schedule').show();$('#schedule_impact_qty').val('TBD');$('#schedule_text').html('TBD');">TBD</a></li>
                                            <li><a href="#" onClick="$('#schedule').hide();$('#schedule_impact_qty').val('');$('#schedule_text').html('No');">No</a></li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group" id="schedule" style="display:none;">
                                <div class="col-sm-12">
                                    {!! Form::label('schedule_impact_qty', 'Estimated Days', array('class' => 'control-label', 'style'=>'padding:0;')) !!}
                                    <div class="input-group">
                                        <span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
                                        {!! Form::text('schedule_impact_qty', 'No', array('class' => 'form-control', 'placeholder' => 'Estimated days...' )) !!}
                                    </div>
                                </div>
                            </div>

                            <!-- Cost Impact -->
                            <div class="form-group no-margin">
                                <div class="col-sm-12">
                                    {!! Form::label('cost_impact', 'Cost Impact', array('class' => 'control-label', 'style'=>'padding:0;')) !!}
                                    <div class="btn-group" style="width:100%;">
                                        <button class="btn btn-default btn-block" data-toggle="dropdown" style="text-align:left;padding:6px 11px;">
                                            <span id="cost_text">No</span> <span class="caret"></span>
                                        </button>
                                        <ul class="dropdown-menu" role="menu" style="width:100%;">
                                            <li><a href="#" onClick="$('#cost').show();$('#cost_text').html('Yes');$('#cost_impact_qty').val('');$('#cost_impact_qty').focus();">Yes</a></li>
                                            <li><a href="#" onClick="$('#cost').show();$('#cost_impact_qty').val('TBD');$('#cost_text').html('TBD');">TBD</a></li>
                                            <li><a href="#" onClick="$('#cost').hide();$('#cost_impact_qty').val('');$('#cost_text').html('No');">No</a></li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group no-margin" id="cost" style="display:none;margin-top:15px;">
                                <div class="col-sm-12">
                                    {!! Form::label('cost_impact_qty', 'Estimated Cost', array('class' => 'control-label', 'style'=>'padding:0;')) !!}
                                    <div class="input-group">
                                        <span class="input-group-addon"><span class="glyphicon glyphicon-usd"></span></span>
                                        {!! Form::text('cost_impact_qty', 'No', array('class' => 'form-control', 'placeholder' => 'Estimated cost...' )) !!}
                                    </div>
                                    <div class="checkbox">
                                        <label>
                                            <input type="checkbox" name="create_pco" checked> <span class="text-muted">Create PCO</span>
                                        </label>
                                    </div>
                                </div>
                            </div>                        
                        </div>
                    </div>
                </div>
            
                <div class="col-lg-9">
                    <div class="panel panel-default">
                        <div class="panel-heading">Subject & Question</div>
                        <div class="panel-body">

                            <!-- Subject -->
                            <div class="form-group">
                                <div class="col-sm-12">
                                    {!! Form::label('subject', 'Subject', array('class' => 'control-label', 'style'=>'padding:0;')) !!}
                                    {!! Form::text('subject', null, array('class' => 'form-control', 'placeholder' => 'Ex. Lobby accent paint colors...', 'required'=>'true' )) !!}
                                    <span class="text-danger">{!! $errors->first('subject') !!}</span>
                                </div>
                            </div>

                            <!-- References -->
                            <div class="form-group">
                                <div class="col-sm-12">
                                    {!! Form::label('references', 'References', array('class' => 'control-label', 'style'=>'padding:0;')) !!}
                                    {!! Form::text('references', null, array('class' => 'form-control', 'placeholder' => 'Ex. 3/A2.01, S6.5...', 'required'=>'true' )) !!}
                                    <span class="text-danger">{!! $errors->first('references') !!}</span>
                                </div>
                            </div>

                            <!-- Question -->
                            <div class="form-group">
                                <div class="col-sm-12">
                                    {!! Form::label('question', 'Question', array('class' => 'control-label', 'style'=>'padding:0;')) !!}
                                    {!! Form::textarea('question', null, array('class' => 'form-control', 'rows' => '5', 'placeholder' => 'Define your problem & suggest a solution...', 'required'=>'true' )) !!}
                                </div>
                            </div>

                            <div class="form-group no-margin">
                                <div class="col-sm-12">
                                    {!! Form::submit('Submit', array('class' => 'btn btn-success')) !!}            
                                    {!! link_to('rfis', 'Save Draft', array('class' => 'btn btn-info btn-spacer-left')) !!}
                                    {!! link_to('rfis', 'Cancel', array('class' => 'btn btn-default btn-spacer-left')) !!}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            {!! Form::close() !!}
        </div>
    </div>
@endsection