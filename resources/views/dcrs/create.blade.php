@extends('layouts.application.main_wide')
@extends('layouts.application.nav_project')
@section('content')
    
    <script type="text/javascript" src="{!! asset('/js/jquery.currency.js') !!}"></script>
    <script type="text/javascript">
        $(document).ready(function(){
             //Date selector
             $("#date").datepicker({
                 changeMonth: true,
                 changeYear: true
             });
        });
    </script>
    
    <div class="page-wrapper">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-7 col-lg-offset-2">
                    <h3 class="text-muted" style="margin-bottom:15px;">Create a New DCR</h3>
                    {!! Form::open(array('url'=>'dcrs', 'method'=>'post', 'class'=>'form-horizontal')) !!}
                        
                        <!-- Subject -->
                        <div class="form-group">
                            <div class="col-sm-12">
                                <span class="text-danger">{!! $errors->first('subject') !!}</span>
                                {!! Form::text('subject', null, array('class' => 'form-control input-lg', 'placeholder' => 'Subject...', 'autofocus' => 'true', 'required'=>'true' )) !!}               
                            </div>
                        </div>
                                                
                        <!-- Assign To -->
                        <div class="form-group">
                            <div class="col-md-6">
                                <span class="text-danger">{!! $errors->first('assign_to') !!}</span>
                                <div class="input-group">
                                    <span class="input-group-addon">
                                        <span class="glyphicon glyphicon-user"></span>
                                    </span>
                                    <div class="input-group-btn" style="width:99%;">
                                        <button class="btn btn-default btn-block" data-toggle="dropdown" style="text-align:left;padding:6px 11px;">
                                            <span class="text-muted">
                                                Assign to
                                                <span class="caret"></span>
                                            </span>
                                        </button>
                                        <ul class="dropdown-menu" role="menu" style="width:100%;">
                                            <!-- List Collaborators -->
                                            @foreach($collaborators as $collaborator)
                                                <li>
                                                    <a href="#" onClick="$('#assign_to').val('{{ $collaborator->user->id }}');">
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

                                </div>
                                {!! Form::hidden('assign_to', null, array('required'=>'true' )) !!}
                            </div>
                            <div class="col-md-6">
                                <div class="checkbox">
                                    <label>
                                        <input type="checkbox" name="assign_to_default" checked> <span class="text-muted">Set as default</span>
                                    </label>
                                </div>
                            </div>
                        </div>
                            
                        <div class="form-group">
                            <!-- Date Due -->
                            <div class="col-md-6">
                                <span class="text-danger">{!! $errors->first('date_due') !!}</span>
                                <div class="input-group">
                                    <span class="input-group-addon" id="addon-date"><span class="glyphicon glyphicon-calendar"></span></span>
                                    {!! Form::text('date', null, array('id' => 'date', 'class' => 'form-control', 'placeholder' => 'Date due', 'required'=>'true', 'aria-describedby' => 'addon-date' )) !!}
                                </div>
                            </div>
                            
                            <!-- Priority -->
                            <div class="col-md-6">
                                <label class="radio-inline text-muted no-padding"><span id="priorityFlame" class="glyphicon glyphicon-fire text-warning" title="Set priority."></span></label>
                                <label class="radio-inline text-danger" style="margin-left:10px;"><input type="radio" name="priority" value="3" onChange="$('#priorityFlame').attr('class', 'glyphicon glyphicon-fire text-danger');"> High</label>
                                <label class="radio-inline text-warning"><input type="radio" name="priority" value="2" checked onChange="$('#priorityFlame').attr('class', 'glyphicon glyphicon-fire text-warning');"> Medium</label>
                                <label class="radio-inline text-info"><input type="radio" name="priority" value="1" onChange="$('#priorityFlame').attr('class', 'glyphicon glyphicon-fire text-info');"> Low</label>
                            </div>
                        </div>

                        <div class="form-group">
                            <!-- Cost Impact Select -->
                            <div class="col-md-6">
                                <label class="radio-inline text-muted" style="padding-top:0;">Cost impact?</label>
                                <label class="radio-inline" style="padding-top:0;"><input type="radio" name="cost_impact" value="Yes" onChange="$('#cost').show();$('#cost_impact_qty').val('');$('#cost_impact_qty').focus();"> Yes</label>
                                <label class="radio-inline" style="padding-top:0;"><input type="radio" name="cost_impact" value="No" onChange="$('#cost').hide();$('#cost_impact_qty').val('');" checked> No</label>
                                <label class="radio-inline" style="padding-top:0;"><input type="radio" name="cost_impact" value="Unknown" onChange="$('#cost').show();$('#cost_impact_qty').val('Unknown');"> Unknown</label>
                            </div>
                            
                            <!-- Schedule Impact Select -->
                            <div class="col-md-6">
                                <label class="radio-inline text-muted" style="padding-top:0;">Schedule impact?</label>
                                <label class="radio-inline" style="padding-top:0;"><input type="radio" name="schedule_impact" value="Yes" onChange="$('#schedule').show();$('#schedule_impact_qty').val('');$('#schedule_impact_qty').focus();"> Yes</label>
                                <label class="radio-inline" style="padding-top:0;"><input type="radio" name="schedule_impact" value="No" onChange="$('#schedule').hide();$('#schedule_impact_qty').val('');" checked> No</label>
                                <label class="radio-inline" style="padding-top:0;"><input type="radio" name="schedule_impact" value="Unknown" onChange="$('#schedule').show();$('#schedule_impact_qty').val('Unknown');"> Unknown</label>
                            </div>
                        </div>                        
                        
                        <div class="form-group no-margin">
                            <!-- Cost Impact -->
                            <div class="col-md-6">
                                <div id="cost" style="display:none;margin-bottom:15px;">
                                    <div class="input-group">
                                        <span class="input-group-addon"><span class="glyphicon glyphicon-usd"></span></span>
                                        {!! Form::text('cost_impact_qty', null, array('id' => 'cost_impact_qty', 'class' => 'form-control', 'placeholder' => 'Estimated cost...' )) !!}
                                    </div>
                                    <div class="checkbox">
                                        <label>
                                            <input type="checkbox" name="create_pco" checked> <span class="text-muted">Create a new PCO</span>
                                        </label>
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Schedule Impact -->
                            <div class="col-md-6">
                                <div id="schedule" style="display:none;margin-bottom:15px;">
                                    <div class="input-group">
                                        <span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
                                        {!! Form::text('schedule_impact_qty', null, array('id' => 'schedule_impact_qty', 'class' => 'form-control', 'placeholder' => 'Estimated days...' )) !!}
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="form-group" style="margin-bottom:0;">
                            <div class="form-inline">
                                <!-- References -->
                                <div class="col-md-6">
                                    <div class="form-group">
                                        {!! Form::text('references', null, array('class' => 'form-control', 'placeholder' => 'References (ex. 7/A9.01)' )) !!}
                                    </div>
                                </div>
                                <!-- Origin -->
                                <div class="col-md-6">
                                    <div class="form-group">
                                        {!! Form::text('origin', null, array('class' => 'form-control', 'placeholder' => 'Origin (ex. Paint Tech RFI #01)', 'required'=>'true' )) !!}
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Attachments -->
                        <div class="form-group">
                            <div class="col-md-6">
                                <div class="file_upload">
                                    <script type="text/javascript">
                                        $(function() {
                                            $('#file').uploadifive({
                                                'multi'       : true,
                                                'width'       : 95,
                                                'height'      : 34,
                                                'buttonCursor' : 'pointer',
                                                'formData'    : {
                                                    'timestamp' : '<?php echo time();?>',
                                                    '_token': '<?php echo csrf_token(); ?>'
                                                },
                                                'queueID'           : 'queue',
                                                'uploadScript'      : '/attachment/upload',
                                                'onUploadComplete'  : function(file, data) {
                                                    console.log(data);
                                                    $("#file_id_list").append('<input type="hidden" id="file_id_' + data + '" name="file_id[]" value="' + data + '"/>');
                                                }
                                            });
                                        });
                                    </script>
                                    {!! Form::file("file", ["id" => "file"]) !!}
                                    <div id="file_id_list"></div>
                                </div>
                                <div id="queue" class="queue"><span class="text-muted"><span class="glyphicon glyphicon-cloud-upload"></span> Drag & drop files here.</span></div>
                            </div>
                        </div>
                        
                        <!-- Question -->
                        <div class="form-group">
                            <div class="col-sm-12">
                                <span class="text-danger">{!! $errors->first('question') !!}</span>
                                {!! Form::textarea('question', null, array('class' => 'form-control', 'rows' => '5', 'placeholder' => 'Define your problem & suggest a solution...', 'required'=>'true' )) !!}
                            </div>
                        </div>
                        
                        <!-- Buttons -->
                        <div class="form-group no-margin">
                            <div class="col-sm-12">
                                {!! Form::submit('Submit', array('class' => 'btn btn-success')) !!}            
                                {!! link_to('rfis', 'Save Draft', array('class' => 'btn btn-info btn-spacer-left')) !!}
                                {!! link_to('rfis', 'Cancel', array('class' => 'btn btn-default btn-spacer-left')) !!}
                            </div>
                        </div>
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
@endsection