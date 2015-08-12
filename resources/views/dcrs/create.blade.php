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
                    <div class="pagehead">
                        <h1><i class="fa fa-plus-circle text-success"></i> Create a New DCR</h1>
                    </div>
                    {!! Form::open(array('url'=>'dcrs', 'method'=>'post', 'class'=>'form-horizontal')) !!}
                        <!-- Date -->
                        <div class="form-group">
                            {!! Form::label('date', 'Report Date', array('class' => 'col-sm-2 control-label')) !!}
                            <div class="col-sm-4">
                                <span class="text-danger">{!! $errors->first('date') !!}</span>
                                <div class="input-group">
                                    <span class="input-group-addon" id="addon-date"><span class="glyphicon glyphicon-calendar"></span></span>
                                    {!! Form::text('date', Timezone::convertFromUTC(Carbon::now(), Auth::user()->timezone, 'm/d/Y'), array('id' => 'date', 'class' => 'form-control', 'placeholder' => 'Report Date', 'required'=>'true', 'aria-describedby' => 'addon-date' )) !!}
                                </div>
                            </div>
                        </div>
                        
                        <!-- Weather -->
                        <div class="form-group">
                            {!! Form::label('weather', 'Weather', array('class' => 'col-sm-2 control-label')) !!}
                            <div class="col-sm-3">
                                {!! Form::select('weather', array(
                                        'Clear'     => 'Clear',
                                        'Partly Cloudy' => 'Partly Cloudy',
                                        'Cloudy'    => 'Cloudy',
                                        'Raining'   => 'Raining',
                                        'Snowing'   => 'Snowing',
                                        'Windy'     => 'Windy'
                                    ), null, array('class' => 'form-control mobile-margin', 'required' => 'true'))
                                !!}
                            </div>
                            <div class="col-sm-3 mobile-margin-end">
                                {!! Form::text('temperature', null, array('class' => 'form-control mobile-margin', 'placeholder' => 'Temp', 'required'=>'true' )) !!}
                            </div>
                            <div class="col-sm-2 mobile-margin-end">
                                <select class="form-control" name="report_temperature_type">
                                    <option value="Fahrenheit">&deg;F</option>
                                    <option value="Celsius">&deg;C</option>
                                </select>
                            </div>
                        </div>
                        
                        <div class="form-group">
                            {!! Form::label('inspection_agency', 'Inspections', array('class' => 'col-sm-2 control-label')) !!}
                            <div id="inspections">
                                <div class="col-sm-5">
                                    <input type="text" class="form-control" id="report_inspection_agency" name="report_inspection_agency[]" placeholder="Inspection Agency" value="" />
                                </div>
                                <div class="col-sm-3 mobile-margin-end">
                                    <input type="text" class="form-control" id="report_inspection_type" name="report_inspection_type[]" placeholder="Type of Inspection" value=""/>
                                </div>
                                <div class="col-sm-2 mobile-margin-end">
                                    <select class="form-control" id="report_inspection_status" name="report_inspection_status[]"  required="true">
                                        <option value="Pass">Pass</option>
                                        <option value="Fail">Fail</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-sm-10 col-sm-offset-2" style="margin-top:5px;">
                                <a href="javascript:void(0);" onClick="new_inspection_line();"><span class="glyphicon glyphicon-plus-sign"></span> Add Inspection</a>
                            </div>
                        </div>
                        
                        <div class="form-group">
                            {!! Form::label('comments', 'Comments', array('class' => 'col-sm-2 control-label')) !!}
                            <div class="col-sm-10">
                                {!! Form::textarea('comments', null, array('class' => 'form-control', 'rows' => '3', 'placeholder' => 'General comments...' )) !!}
                            </div>
                        </div>
                    
                        <div class="form-group">
                            {!! Form::label('correspondence', 'Correspondence', array('class' => 'col-sm-2 control-label')) !!}
                            <div class="col-sm-10">
                                {!! Form::textarea('correspondence', null, array('class' => 'form-control', 'rows' => '3', 'placeholder' => 'Phone calls, meetings, etc...' )) !!}
                            </div>
                        </div>
                    
                        <div class="form-group">
                            {!! Form::label('issues', 'Critical Issues', array('class' => 'col-sm-2 control-label')) !!}
                            <div class="col-sm-10">
                                {!! Form::textarea('issues', null, array('class' => 'form-control', 'rows' => '3', 'placeholder' => 'Lead times, field issues, etc...' )) !!}
                            </div>
                        </div>
                    
                        <div class="form-group">
                            {!! Form::label('safety', 'Safety Issues', array('class' => 'col-sm-2 control-label')) !!}
                            <div class="col-sm-10">
                                {!! Form::textarea('safety', null, array('class' => 'form-control', 'rows' => '3', 'placeholder' => 'Not tied off, frayed cords, etc...' )) !!}
                            </div>
                        </div>
                        
                        <!-- Attachments -->
                        <div class="form-group">
                            {!! Form::label('file', 'Attachments', array('class' => 'col-sm-2 control-label')) !!}
                            <div class="col-sm-6">
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
                                                                       
                        <!-- Buttons -->
                        <div class="form-group no-margin">
                            <div class="col-sm-10 col-sm-offset-2">
                                {!! Form::submit('Submit', array('class' => 'btn btn-success')) !!}            
                                {!! link_to('dcrs', 'Save Draft', array('class' => 'btn btn-info btn-spacer-left')) !!}
                                {!! link_to('dcrs', 'Cancel', array('class' => 'btn btn-default btn-spacer-left')) !!}
                            </div>
                        </div>
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
@endsection