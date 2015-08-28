@extends('layouts.application.main_wide')
@extends('layouts.application.nav_project')
@section('content')
    
    <script type="text/javascript" src="{!! asset('/js/jquery.currency.js') !!}"></script>
    <script type="text/javascript" src="{!! asset('/js/dcrs.js') !!}"></script>
    <script type="text/javascript">
        $(document).ready(function(){
            //Date selector
            $("#date").datepicker({
                changeMonth: true,
                changeYear: true
            });
            //Format crew hours
            $('#crew_hours_input').blur(function() {
                $('#crew_hours_input').currency({decimals: 1});
            });
        });
    </script>
    
    <div class="page-wrapper">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-7 col-lg-offset-2">
                    <div class="pagehead">
                        <h1><i class="fa fa-plus-circle text-success"></i> Create a New Daily Report</h1>
                    </div>
                    {!! Form::open(array('url'=>'dcrs', 'method'=>'post', 'class'=>'form-horizontal')) !!}
                        <!-- Date -->
                        <div class="form-group">
                            {!! Form::label('date', 'Report Date', array('class' => 'col-sm-2 control-label')) !!}
                            <div class="col-sm-4">
                                <span class="text-danger">{!! $errors->first('date') !!}</span>
                                <div class="input-group">
                                    <span class="input-group-addon" id="addon-date"><i class="fa fa-calendar"></i></span>
                                    {!! Form::text('date', Timezone::convertFromUTC(Carbon::now(), Auth::user()->timezone, 'm/d/Y'), array('id' => 'date', 'class' => 'form-control', 'placeholder' => 'Report Date', 'required'=>'true', 'aria-describedby' => 'addon-date' )) !!}
                                </div>
                            </div>
                        </div>
                        
                        <!-- Weather -->
                        <div class="form-group">
                            {!! Form::label('weather', 'Weather', array('class' => 'col-sm-2 control-label')) !!}
                            <div class="col-sm-4">
                                <div class="input-group">
                                    <span class="input-group-addon" id="addon-weather"><i id="weather-icon" class="wi wi-day-sunny"></i></span>
                                    {!! Form::select('weather', array(
                                            'Clear'     => 'Clear',
                                            'Partly Cloudy' => 'Partly Cloudy',
                                            'Cloudy'    => 'Cloudy',
                                            'Rain'   => 'Rain',
                                            'Snow'   => 'Snow',
                                            'Wind'     => 'Wind'
                                        ), null, array('onChange'=>'$(\'#weather-icon\').attr("class", "wi wi-" + this.value.replace(/\s/g, \'\'))', 'class' => 'form-control', 'required' => 'true'))
                                    !!}
                                </div>
                            </div>
                            <div class="col-sm-3 col-md-2 mobile-margin-end">
                                {!! Form::text('temperature', null, array('class' => 'form-control mobile-margin', 'placeholder' => 'Temp', 'required'=>'true' )) !!}
                            </div>
                            <div class="col-sm-2 mobile-margin-end">
                                {!! Form::select('temperature_type', array(
                                        'Fahrenheit' => '&deg;F',
                                        'Celsius' => '&deg;C'
                                    ), null, array('class' => 'form-control', 'required' => 'true'))
                                !!}
                            </div>
                        </div>
                        
                        <div class="form-group">
                            {!! Form::label('work', 'Work Today', array('class' => 'col-sm-2 control-label')) !!}
                            <div class="col-sm-10">
                                <table class="table table-hover table-condensed table-sortable no-margin">
                                    <thead>
                                        <th>Company</th>
                                        <th>Crew</th>
                                        <th class="tablet-hide">Hours</th>
                                        <th>Work Performed</th>
                                        <th></th>
                                    </thead>
                                    <tbody id="work-table">
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <div class="col-sm-10 col-sm-offset-2">
                                <div class="row">
                                    <div class="col-sm-6">
                                        <input type="text" class="form-control" id="crew_company_input" placeholder="Company" value="" />
                                    </div>
                                    <div class="col-sm-3 mobile-margin-end">
                                        <input type="number" class="form-control" id="crew_size_input" min="0" step="1" placeholder="Crew size" value=""/>
                                    </div>
                                    <div class="col-sm-3 mobile-margin-end">
                                        <input type="number" class="form-control" id="crew_hours_input" min="0" step="0.5" placeholder="Hours" value=""/>
                                    </div>
                                    <div class="col-sm-12" style="margin-top:10px;">
                                        {!! Form::textarea('crew_work_input', null, array('id' => 'crew_work_input', 'class' => 'form-control', 'rows' => '2', 'placeholder' => 'Work performed today...' )) !!}
                                    </div>
                                    <div class="col-sm-12" style="margin-top:8px;">
                                        <span class="btn btn-sm btn-info" onClick="addWork();"><i class="fa fa-plus"></i> Add to Log</span>
                                        <span class="text-danger btn-spacer-left" style="display:none;" id="workError">*All fields are required to add work performed.</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="form-group">
                            {!! Form::label('equipment', 'Equipment', array('class' => 'col-sm-2 control-label')) !!}
                            <div id="equipment-wrapper" class="col-sm-offset-2">
                                <div class="col-sm-12" style="margin-bottom:8px;">
                                    <div class="row">
                                        <div class="col-sm-6">
                                            <input type="text" class="form-control" name="equipment_type[]" placeholder="Type of equipment" value="" />
                                        </div>
                                        <div class="col-sm-3 mobile-margin-end">
                                            <input type="number" class="form-control" name="equipment_qty[]" min="0" placeholder="Qty" value=""/>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-10 col-sm-offset-2">
                                <span class="btn-link-light" onClick="addEquipment();"><i class="fa fa-plus-circle"></i> Add Equipment</span>
                            </div>
                        </div>
                        
                        <div class="form-group">
                            {!! Form::label('inspection_agency', 'Inspections', array('class' => 'col-sm-2 control-label')) !!}
                            <div id="inspection-wrapper" class="col-sm-offset-2">
                                <div class="col-sm-12" style="margin-bottom:8px;">
                                    <div class="row">
                                        <div class="col-sm-6">
                                            <input type="text" class="form-control" name="inspection_agency[]" placeholder="Inspection agency" value="" />
                                        </div>
                                        <div class="col-sm-3 mobile-margin-end">
                                            <input type="text" class="form-control" name="inspection_type[]" placeholder="Type of inspection" value=""/>
                                        </div>
                                        <div class="col-sm-3 mobile-margin-end">
                                            <select class="form-control" name="inspection_status[]"  required="true">
                                                <option value="Pass">Pass</option>
                                                <option value="Fail">Fail</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-10 col-sm-offset-2">
                                <span class="btn-link-light" onClick="addInspection();"><span class="glyphicon glyphicon-plus-sign"></span> Add Inspection</span>
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
                                {!! Form::submit('Save Report', array('class' => 'btn btn-success')) !!}
                                {!! link_to('dcrs', 'Cancel', array('class' => 'btn btn-default btn-spacer-left')) !!}
                            </div>
                        </div>
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
@endsection