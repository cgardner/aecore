@extends('layouts.application.main')
@section('content')
    <script type="text/javascript" src="{!! asset('/js/countries.js') !!}"></script>
    <script type="text/javascript" src="{!! asset('/js/jquery.currency.js') !!}"></script>

    <script type="text/javascript">
        $(document).ready(function () {
            $('#value').blur(function () {
                $('#value').currency();
            });
            $('#size').blur(function () {
                $('#size').currency();
            });
            //Date selectors
            $("#start").datepicker({
                changeMonth: true,
                changeYear: true
            });
            $("#finish").datepicker({
                changeMonth: true,
                changeYear: true
            });
        });

        function update_size_unit(unit) {
            if (unit == "feet") {
                $('#size_unit_button_text').text('SQ FT');
                $('#size_unit').val('feet');
            } else if (unit == "meters") {
                $('#size_unit_button_text').text('SQ M');
                $('#size_unit').val('meters');
            }
        }
    </script>

    @yield('form-open')

        <div class="panel panel-default">
            <div class="panel-heading">Basic Information</div>
            <div class="panel-body">
                <div class="form-group">
                    {!! Form::label('status', 'Status', array('class' => 'col-sm-2 control-label')) !!}
                    <div class="col-sm-6 col-md-4 col-lg-3">
                        <span class="text-danger">{!! $errors->first('status') !!}</span>
                        {!! Form::select('status', array(
                                'Bid' => 'Bid',
                                'Pre-construction' => 'Pre-construction',
                                'Under Construction' => 'Under Construction',
                                'Archived' => 'Archived' ),
                            null, array('class'=>'form-control', 'required'=>'true'))!!}
                    </div>
                </div>

                <div class="form-group">
                    {!! Form::label('type', 'Type', array('class' => 'col-sm-2 control-label')) !!}
                    <div class="col-sm-6 col-md-4 col-lg-3">
                        <span class="text-danger">{!! $errors->first('type') !!}</span>
                        {!! Form::select('type', array( 'Core & Shell' => 'Core & Shell', 'Commercial' => 'Commercial', 'Clerical' => 'Clerical', 'Data Center' => 'Data Center', 'Education' => 'Education', 'Flatwork' => 'Flatwork', 'Medical & Health Care' => 'Medical & Health Care', 'Heavy Civil' => 'Heavy Civil', 'High-tech' => 'High-tech', 'Industrial' => 'Industrial', 'Office' => 'Office', 'Parking Structure' => 'Parking Structure', 'Parks & Recreation' => 'Parks & Recreation', 'Residential' => 'Residential', 'Retail' => 'Retail', 'Service Work' => 'Service Work', 'Seismic Retrofit' => 'Seismic Retrofit', 'Tenant Improvement' => 'Tenant Improvement', 'Tilt-Up' => 'Tilt-Up', 'Transportation' => 'Transportation' ), null, array('class'=>'form-control', 'required'=>'true')) !!}
                    </div>
                </div>

                <div class="form-group">
                    {!! Form::label('number', 'Job Number', array('class' => 'col-sm-2 control-label')) !!}
                    <div class="col-sm-6 col-md-4 col-lg-3">
                        <span class="text-danger">{!! $errors->first('number') !!}</span>
                        {!! Form::text('number', null, array('class' => 'form-control', 'placeholder' => 'ex. 1357', 'required'=>'true' )) !!}
                    </div>
                </div>

                <div class="form-group">
                    {!! Form::label('name', 'Name', array('class' => 'col-sm-2 control-label')) !!}
                    <div class="col-sm-6">
                        <span class="text-danger">{!! $errors->first('name') !!}</span>
                        {!! Form::text('name', null, array('class' => 'form-control', 'placeholder' => 'ex. Park Plaza TI', 'required'=>'true' )) !!}
                    </div>
                </div>

                <div class="form-group">
                    {!! Form::label('start', 'Schedule', array('class' => 'col-sm-2 control-label')) !!}
                    <div class="col-sm-3">
                        <div class="input-group">
                            <span class="input-group-addon"><span class="glyphicon glyphicon-star-empty"></span></span>
                            {!! Form::text('start', null, array('id'=>'start', 'class' => 'form-control', 'placeholder' => 'Date Start', 'required'=>'true' )) !!}
                        </div>
                    </div>
                    <div class="col-sm-3">
                        <div class="input-group">
                            <span class="input-group-addon"><span class="glyphicon glyphicon-star"></span></span>
                            {!! Form::text('finish', null, array('id'=>'finish', 'class' => 'form-control', 'placeholder' => 'Date Finish', 'required'=>'true' )) !!}
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    {!! Form::label('value', 'Value', array('class' => 'col-sm-2 control-label')) !!}
                    <div class="col-sm-6 col-md-3">
                        <div class="input-group">
                            <span class="input-group-addon">$</span>
                            {!! Form::text('value', null, array('id'=>'value', 'class' => 'form-control', 'placeholder' => 'ex. 155,000' )) !!}
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-sm-2 control-label" for="size">Size</label>

                    <div class="col-sm-3">
                        <div class="input-group">
                            {!! Form::text('size', null, array('id'=>'size', 'class' => 'form-control', 'placeholder' => 'ex. 24,500')) !!}
                            {!! Form::hidden('size_unit', 'feet', array('id'=>'size_unit')) !!}
                            <div class="input-group-btn">
                                <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown">
                                    <span id="size_unit_button_text">SQ FT</span> <span class="caret"></span></button>
                                <ul class="dropdown-menu pull-right">
                                    <li><a href="#" id="feet" onclick="update_size_unit('feet');">Square Feet</a></li>
                                    <li><a href="#" id="meters" onclick="update_size_unit('meters');">Square Meters</a></li>
                                </ul>
                            </div>
                            <!-- /btn-group -->
                        </div>
                        <!-- /input-group -->
                    </div>
                </div>

                <div class="form-group no-margin">
                    {!! Form::label('description', 'Description', array('class' => 'col-sm-2 control-label')) !!}
                    <div class="col-sm-6">
                        {!! Form::textarea('description', null, array('class' => 'form-control', 'rows'=>'4', 'placeholder' => 'Project Description...' )) !!}
                    </div>
                </div>
            </div>
        </div>

        <div class="panel panel-default">
            <div class="panel-heading">Project Location</div>
            <div class="panel-body">
                <div class="form-group">
                    {!! Form::label('street', 'Street', array('class' => 'col-sm-2 control-label')) !!}
                    <div class="col-sm-6 col-md-5">
                        <span class="text-danger">{!! $errors->first('street') !!}</span>
                        {!! Form::text('street', null, array('class' => 'form-control', 'placeholder' => 'Street' )) !!}
                    </div>
                </div>

                <div class="form-group">
                    {!! Form::label('city', 'City', array('class' => 'col-sm-2 control-label')) !!}
                    <div class="col-sm-6 col-md-5">
                        <span class="text-danger">{!! $errors->first('city') !!}</span>
                        {!! Form::text('city', null, array('class' => 'form-control', 'placeholder' => 'City' )) !!}
                    </div>
                </div>

                <div class="form-group">
                    {!! Form::label('country', 'Country', array('class' => 'col-sm-2 control-label')) !!}
                    <div class="col-sm-6 col-md-5">
                        <span class="text-danger">{!! $errors->first('country') !!}</span>
                        {!! Form::select('country', array( '' => 'Select Country' ), null, array('class' => 'form-control', 'onChange' => 'print_state(\'state\', this.selectedIndex)')) !!}
                    </div>
                </div>

                <div class="form-group">
                    {!! Form::label('state', 'State', array('class' => 'col-sm-2 control-label')) !!}
                    <div class="col-sm-6 col-md-5">
                        <span class="text-danger">{!! $errors->first('state') !!}</span>
                        {!! Form::select('state', array( '' => 'Select State' ), null, array('class' => 'form-control')) !!}
                    </div>
                </div>

                <div class="form-group no-margin">
                    {!! Form::label('zip_code', 'Zip Code', array('class' => 'col-sm-2 control-label')) !!}
                    <div class="col-sm-6 col-md-5">
                        <span class="text-danger">{!! $errors->first('zipcode') !!}</span>
                        {!! Form::text('zip_code', null, array('class' => 'form-control', 'placeholder' => 'Zip Code' )) !!}
                    </div>
                </div>
            </div>
        </div>

        <div class="panel panel-default">
            <div class="panel-heading">Project Settings</div>
            <div class="panel-body">
                <div class="form-group">
                    {!! Form::label('submittal_code', 'Submittal Numbers', array('class' => 'col-sm-2 control-label')) !!}
                    <div class="col-sm-4">
                        {!! Form::select('submittal_code', array(
                            'csicode' => 'CSI Master Format 2004',
                            'costcode' => 'Cost Codes'
                            ), null, array('class'=>'form-control', 'required'=>'true'))
                        !!}
                    </div>
                </div>
                
                <div class="form-group no-margin">
                    <div class="col-sm-offset-2 col-sm-6 col-md-4 col-lg-3">
                        @yield('form-buttons')
                    </div>
                </div>
            </div>
        </div>
  {!! Form::close() !!}
@endsection