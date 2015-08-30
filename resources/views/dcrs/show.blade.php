@extends('layouts.application.main_wide')
@extends('layouts.application.nav_project')
@section('content')
  <div class="page-wrapper">
    <div class="container-fluid">
        <div class="pagehead">
            <a href="{!! URL::to('pdf/dcr') !!}" class="btn btn-default pull-right btn-spacer-left mobile-hide" target="_blank" title="Print Daily Report."><i class="fa fa-print"></i> Print</a>
            <div class="btn-group pull-right" role="group">
                <a href="/dcrs/{!! @$dcr_previous->id !!}" class="btn btn-default mobile-hide <?php if(@$dcr_previous->id == NULL) { echo 'disabled'; } ?>"><i class="fa fa-arrow-circle-left"></i> Previous</a>
                <a href="/dcrs/{!! @$dcr_next->id !!}" class="btn btn-default mobile-hide <?php if(@$dcr_next->id == NULL) { echo 'disabled'; } ?>">Next <i class="fa fa-arrow-circle-right"></i></a>
            </div>
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
                    <p class="form-control-static"><i class="wi wi-{!! str_replace(' ', '', $dcr->weather) !!}"></i> {!! $dcr->weather . ' ' . $dcr->temperature . '&deg; ' . $dcr->temperature_type[0] !!}</p>
                </div>
            </div>

            <!-- Work Today -->
            <div class="form-group">
                {!! Form::label('work', 'Work Today', array('class' => 'col-sm-2 control-label')) !!}
                <div class="col-sm-10 col-lg-8">
                    @if(count($dcrWorks) > 0)                    
                        <table class="table table-hover table-condensed table-sortable no-margin">
                            <thead>
                                <th>Company</th>
                                <th class="mobile-hide">Crew</th>
                                <th class="tablet-hide">Hours</th>
                                <th>Work Performed</th>
                            </thead>
                            <tbody id="work-table">
                                @foreach($dcrWorks as $dcrWork)
                                    <tr>
                                        <td style="width:20%;">{!! $dcrWork->crew_company !!}</td>
                                        <td class="mobile-hide" style="width:15%;">{!! $dcrWork->crew_size !!}</td>
                                        <td class="tablet-hide" style="width:15%;">{!! $dcrWork->crew_hours !!}</td>
                                        <td>{!! $dcrWork->crew_work !!}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>                        
                    @else
                        <p class="form-control-static">N/A</p>
                    @endif              
                </div>
            </div>
            
            <!-- Equipment -->
            <div class="form-group">
                {!! Form::label('equipment', 'Equipment', array('class' => 'col-sm-3 col-md-2 control-label')) !!}
                <div class="col-sm-9 col-md-10">
                    @if(count($dcrEquipments) > 0)
                        @foreach($dcrEquipments as $dcrEquipment)
                            <p class="form-control-static">{!! '('.$dcrEquipment->equipment_qty.') ' . $dcrEquipment->equipment_type !!}</p>
                        @endforeach
                    @else
                        <p class="form-control-static">N/A</p>
                    @endif
                </div>
            </div>

            <!-- Inspection -->
            <div class="form-group">
                {!! Form::label('inspection', 'Inspections', array('class' => 'col-sm-3 col-md-2 control-label')) !!}
                <div class="col-sm-9 col-md-10">
                    @if(count($dcrInspections) > 0)
                        @foreach($dcrInspections as $dcrInspection)
                            <p class="form-control-static">{!! $dcrInspection->inspection_agency . ' - ' . $dcrInspection->inspection_type . ' (' . $dcrInspection->inspection_status . ')' !!}</p>
                        @endforeach
                    @else
                        <p class="form-control-static">N/A</p>
                    @endif
                </div>
            </div>
            
            <!-- Comments -->
            <div class="form-group">
                {!! Form::label('comments', 'Comments', array('class' => 'col-sm-3 col-md-2 control-label')) !!}
                <div class="col-sm-9 col-md-10">
                    @if($dcr->comments != "")
                        <p class="form-control-static">{!! nl2br($dcr->comments) !!}</p>
                    @else
                        <p class="form-control-static">N/A</p>
                    @endif
                </div>
            </div>

            <!-- Correspondence -->
            <div class="form-group">
                {!! Form::label('correspondence', 'Correspondence', array('class' => 'col-sm-3 col-md-2 control-label')) !!}
                <div class="col-sm-9 col-md-10">
                    @if($dcr->correspondence != "")
                        <p class="form-control-static">{!! nl2br($dcr->correspondence) !!}</p>
                    @else
                        <p class="form-control-static">N/A</p>
                    @endif
                </div>
            </div>

            <!-- Critical Issues -->
            <div class="form-group">
                {!! Form::label('issues', 'Critical Issues', array('class' => 'col-sm-3 col-md-2 control-label')) !!}
                <div class="col-sm-9 col-md-10">
                    @if($dcr->issues != "")
                        <p class="form-control-static">{!! nl2br($dcr->issues) !!}</p>
                    @else
                        <p class="form-control-static">N/A</p>
                    @endif
                </div>
            </div>

            <!-- Safety -->
            <div class="form-group">
                {!! Form::label('safety', 'Safety Issues', array('class' => 'col-sm-3 col-md-2 control-label')) !!}
                <div class="col-sm-9 col-md-10">
                    @if($dcr->safety != "")
                        <p class="form-control-static">{!! nl2br($dcr->safety) !!}</p>
                    @else
                        <p class="form-control-static">N/A</p>
                    @endif
                </div>
            </div>

            <!-- Attachments -->
            <div class="form-group">
                {!! Form::label('safety', 'Attachments', array('class' => 'col-sm-3 col-md-2 control-label')) !!}
                <div class="col-sm-9 col-md-10">
                    @if(count($dcrAttachments) > 0)
                        <?php $s3 = AWS::get('s3'); ?>
                        @foreach($dcrAttachments as $dcrAttachment)
                            <div class="attachment-tile" id="attachment-{!! $dcrAttachment->s3file->file_id !!}">
                                {!! $functionscontroller->display_file_icon($dcrAttachment->s3file->file_name) !!}
                                <p class="l1">
                                    {!! $dcrAttachment->s3file->file_name !!}
                                </p>
                                <p class="l2">
                                    <a href="{!! $s3->getObjectUrl($dcrAttachment->s3file->file_bucket, $dcrAttachment->s3file->file_path . '/' . $dcrAttachment->s3file->file_name); !!}" title="Download attachment.">
                                    <span class="glyphicon glyphicon-cloud-download"></span> Download</a> - {!! $functionscontroller->formatBytes($dcrAttachment->s3file->file_size) !!}
                                </p>
                            </div>
                        @endforeach
                    @else
                        <p class="form-control-static">N/A</p>
                    @endif
                </div>
            </div>
            
            <!-- Buttons -->
            <div class="form-group no-margin">
                <div class="col-sm-10 col-sm-offset-2">
                    <a href="{!! '/dcrs/' . $dcr->id . '/edit' !!}" class="btn btn-default" title="Edit report."><i class="fa fa-pencil"></i> Edit</a>
                </div>
            </div>
            
        </div>
    </div>
  </div>
@endsection
