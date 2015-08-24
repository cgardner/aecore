@extends('layouts.application.main_wide')
@extends('layouts.application.nav_project')
@section('content')
  <div class="page-wrapper">
    <div class="container-fluid">
        <div class="pagehead">
            <a href="#" class="btn btn-default pull-right btn-spacer-left mobile-hide" title="Print"><i class="fa fa-print"></i> Print</a>
            @if(@$dcr_next->id != NULL)
                <a href="/dcrs/{!! $dcr_next->id !!}" class="btn btn-default pull-right btn-spacer-left mobile-hide">Next <i class="fa fa-arrow-circle-right"></i></a>
            @endif
            @if(@$dcr_previous->id != NULL)
                <a href="/dcrs/{!! $dcr_previous->id !!}" class="btn btn-default pull-right mobile-hide"><i class="fa fa-arrow-circle-left"></i> Previous</a>
            @endif
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

            <!-- Work Today -->
            <div class="form-group">
                {!! Form::label('work', 'Work Today', array('class' => 'col-sm-2 control-label')) !!}
                <div class="col-sm-10">
                    <table class="table table-hover table-condensed table-sortable no-margin">
                        <thead>
                            <th>Company</th>
                            <th>Crew</th>
                            <th class="tablet-hide">Hours</th>
                            <th>Work Performed</th>
                        </thead>
                        <tbody id="work-table">
                            @foreach($dcrWorks as $dcrWork)
                                <tr>
                                    <td>{!! $dcrWork->crew_company !!}</td>
                                    <td>{!! $dcrWork->crew_size !!}</td>
                                    <td>{!! $dcrWork->crew_hours !!}</td>
                                    <td>{!! $dcrWork->crew_work !!}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            
            <!-- Equipment -->
            <div class="form-group">
                {!! Form::label('equipment', 'Equipment', array('class' => 'col-sm-3 col-md-2 control-label')) !!}
                <div class="col-sm-9 col-md-10">
                    @foreach($dcrEquipments as $dcrEquipment)
                        <p class="form-control-static">{!! '('.$dcrEquipment->equipment_qty.') ' . $dcrEquipment->equipment_type !!}</p>
                    @endforeach  
                </div>
            </div>

            <!-- Inspection -->
            <div class="form-group">
                {!! Form::label('inspection', 'Inspections', array('class' => 'col-sm-3 col-md-2 control-label')) !!}
                <div class="col-sm-9 col-md-10">
                    @foreach($dcrInspections as $dcrInspection)
                        <p class="form-control-static">{!! $dcrInspection->inspection_agency . ' - ' . $dcrInspection->inspection_type . ' (' . $dcrInspection->inspection_status . ')' !!}</p>
                    @endforeach  
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
