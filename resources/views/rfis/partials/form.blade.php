<?php
use App\Models\Rfi; ?>
@if($rfi->id)
{!! Form::open(['url' => route('rfis.update', ['rfis' => $rfi->id]), 'method' => 'put', 'class' => 'form-horizontal']) !!}
@else
{!! Form::open(array('url' => route('rfis.store'), 'method' => 'post', 'class' => 'form-horizontal')) !!}
@endif

<!-- Subject -->
<div class="form-group">
    {!! Form::label('subject', 'Subject', array('class' => 'col-sm-2 control-label')) !!}
    <div class="col-sm-10">
        <span class="text-danger">{!! $errors->first('subject') !!}</span>
        {!! Form::text('subject', $rfi->subject, array('class' => 'form-control', 'placeholder' => 'Enter a brief description of this RFI...', 'autofocus' => 'true', 'required'=>'true' )) !!}
    </div>
</div>

<!-- Assign To -->
<div class="form-group">
    {!! Form::label('', 'Assign to', array('class' => 'col-sm-2 control-label')) !!}
    <div class="col-sm-6 col-md-5">
        <span class="text-danger">{!! $errors->first('assign_to') !!}</span>

        <div class="input-group">
            <span class="input-group-addon">
                <span class="glyphicon glyphicon-user"></span>
            </span>

            <div class="input-group-btn" style="width:99%;">
                <button class="btn btn-default btn-block" data-toggle="dropdown" style="text-align:left;padding:6px 11px;">
                    <span class="text-muted">
                        Select a collaborator
                        <span class="caret"></span>
                    </span>
                </button>
                <ul class="dropdown-menu" role="menu" style="width:100%;">
                    <!-- List Collaborators -->
                    @foreach($collaborators as $collaborator)
                        <li>
                            <a href="#" onClick="$('#assign_to').val('{{ $collaborator->user->id }}');">
                                @include('rfis.partials.collaborator', ['collaborator' => $collaborator->user])
                            </a>
                        </li>
                    @endforeach
                    <li class="divider"></li>
                    <li>
                        <a href="/collaborators/add" data-target="#modal" data-toggle="modal">
                            <span class="glyphicon glyphicon-plus"></span> Add a Collaborator
                        </a>
                    </li>
                </ul>
            </div>
        </div>
        {!! Form::hidden('assigned_user_id', $rfi->assigned_user_id ?: null, array('required'=>'true', 'id' => 'assign_to')) !!}
    </div>
    <div class="col-sm-4 col-md-5">
        <div class="checkbox">
            <label>
                <input type="checkbox" name="assign_to_default" checked> <span class="text-muted">Set as default</span>
            </label>
        </div>
    </div>
</div>

<!-- Date Due -->
<div class="form-group">
    {!! Form::label('date', 'Date due', array('class' => 'col-sm-2 control-label')) !!}
    <div class="col-sm-6 col-md-5">
        <span class="text-danger">{!! $errors->first('date_due') !!}</span>
        <div class="input-group">
            <span class="input-group-addon" id="addon-date"><i class="fa fa-calendar"></i></span>
            {!! Form::text('due_date', $rfi->due_date ?: null, array('id' => 'date', 'class' => 'form-control', 'placeholder' => 'Select date', 'required'=>'true', 'aria-describedby' => 'addon-date' )) !!}
        </div>
    </div>
</div>

{{ $rfi->priority === Rfi::PRIORITY_MEDIUM }}
<!-- Priority -->
<div class="form-group">
    {!! Form::label('priority', 'Priority', array('class' => 'col-sm-2 control-label')) !!}
    <div class="col-sm-6 col-md-5">
        <label class="radio-inline text-muted no-padding"><span id="priorityFlame" class="glyphicon glyphicon-fire text-warning" title="Set priority."></span></label>
        <label class="radio-inline text-danger" style="margin-left:10px;">
            <input type="radio" {{ $rfi->priority === Rfi::PRIORITY_HIGH ? 'checked ' : null }}name="priority" value="{!! Rfi::PRIORITY_HIGH !!}"
                   onChange="$
            ('#priorityFlame').attr('class', 'glyphicon glyphicon-fire text-danger');"> High
        </label>
        <label class="radio-inline text-warning">
            <input type="radio" {{ is_null($rfi->priority) || $rfi->priority === Rfi::PRIORITY_MEDIUM ? 'checked ' : null }}name="priority" value="{!! Rfi::PRIORITY_MEDIUM !!}" onChange="$('#priorityFlame').attr('class', 'glyphicon glyphicon-fire text-warning');"> Medium
        </label>
        <label class="radio-inline text-info">
            <input type="radio" {{ $rfi->priority === Rfi::PRIORITY_LOW ? 'checked ' : null }}name="priority" value="{!! Rfi::PRIORITY_LOW !!}" onChange="$('#priorityFlame').attr('class', 'glyphicon glyphicon-fire text-info');"> Low
        </label>
    </div>
</div>

<div class="form-group">
    <!-- Cost Impact Select -->
    {!! Form::label('cost_impact', 'Cost impact', array('class' => 'col-sm-2 control-label')) !!}
    <div class="col-sm-10 col-md-5">
        <label class="radio-inline">
            <input type="radio" {{ $rfi->cost_impact === Rfi::COST_IMPACT_YES ? 'checked ' : null }}name="cost_impact" value="{!! Rfi::COST_IMPACT_YES !!}" onChange="$('#cost').show();$('#cost_impact_qty').val('');$('#cost_impact_qty').focus();"> Yes
        </label>
        <label class="radio-inline">
            <input type="radio" {{ $rfi->cost_impact === Rfi::COST_IMPACT_NO ? 'checked ' : null }}name="cost_impact" value="{!! Rfi::COST_IMPACT_NO !!}" onChange="$('#cost').hide();$
            ('#cost_impact_qty').val('');"> No
        </label>
        <label class="radio-inline">
            <input type="radio" {{ is_null($rfi->cost_impact) || $rfi->cost_impact === Rfi::COST_IMPACT_TBD ? 'checked ' : null }}name="cost_impact" value="{!! Rfi::COST_IMPACT_TBD !!}" onChange="$('#cost').show();$('#cost_impact_qty').val('TBD');"> TBD
        </label>

        <!-- Cost Impact -->
        <div id="cost" style="display:none;margin-top:15px;">
            <div class="input-group">
                <span class="input-group-addon"><span class="glyphicon glyphicon-usd"></span></span>
                {!! Form::text('cost_impact_amount', $rfi->cost_impact_qty, array('id' => 'cost_impact_qty', 'class' => 'form-control', 'placeholder' => 'Estimated cost...' )) !!}
            </div>
            <div class="checkbox">
                <label>
                    <input type="checkbox" name="create_pco" checked> <span class="text-muted">Create a new PCO</span>
                </label>
            </div>
        </div>
    </div>
</div>

<div class="form-group">
    <!-- Schedule Impact Select -->
    {!! Form::label('schedule_impact', 'Schedule impact', array('class' => 'col-sm-2 control-label')) !!}
    <div class="col-sm-10 col-md-5">
        <label class="radio-inline">
            <input type="radio" {{ $rfi->schedule_impact === Rfi::SCHEDULE_IMPACT_YES ? 'checked ' : null }}name="schedule_impact" value="{!! Rfi::SCHEDULE_IMPACT_YES !!}" onChange="$('#schedule').show();$('#schedule_impact_qty').val('');$('#schedule_impact_qty').focus();"> Yes
        </label>
        <label class="radio-inline">
            <input type="radio" {{ $rfi->schedule_impact === Rfi::SCHEDULE_IMPACT_NO ? 'checked ' : null }}name="schedule_impact" value="{!! Rfi::SCHEDULE_IMPACT_NO !!}" onChange="$('#schedule').hide();$('#schedule_impact_qty').val('');"> No
        </label>
        <label class="radio-inline">
            <input type="radio" {{ is_null($rfi->schedule_impact) || $rfi->schedule_impact === Rfi::SCHEDULE_IMPACT_TBD ? 'checked ' : null }}name="schedule_impact" value="{!! Rfi::SCHEDULE_IMPACT_TBD !!}" onChange="$('#schedule').show();$('#schedule_impact_qty').val('TBD');"> TBD
        </label>

        <!-- Schedule Impact -->
        <div id="schedule" style="display:none;margin-top:15px;">
            <div class="input-group">
                <span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
                {!! Form::text('schedule_impact_days', $rfi->schedule_impact_days, array('id' => 'schedule_impact_qty', 'class' => 'form-control', 'placeholder' => 'Estimated days...' )) !!}
            </div>
        </div>
    </div>
</div>

<!-- References -->
<div class="form-group">
    {!! Form::label('references', 'References', array('class' => 'col-sm-2 control-label')) !!}
    <div class="col-sm-8 col-md-6">
        {!! Form::text('references', $rfi->references, array('class' => 'form-control', 'placeholder' => 'References (ex. 7/A9.01)' )) !!}
    </div>
</div>

<!-- Origin -->
<div class="form-group">
    {!! Form::label('origin', 'Origin', array('class' => 'col-sm-2 control-label')) !!}
    <div class="col-sm-8 col-md-6">
        {!! Form::text('origin', $rfi->origin, array('class' => 'form-control', 'placeholder' => 'Origin (ex. Paint Tech RFI #01)', 'required'=>'true' )) !!}
    </div>
</div>

<!-- Attachments -->
<div class="form-group">
    {!! Form::label('file', 'Attachments', array('class' => 'col-sm-2 control-label')) !!}
    <div class="col-sm-8 col-md-6">
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
    {!! Form::label('question', 'Question', array('class' => 'col-sm-2 control-label')) !!}
    <div class="col-sm-10">
        <span class="text-danger">{!! $errors->first('question') !!}</span>
        {!! Form::textarea('question', $rfi->question, array('class' => 'form-control', 'rows' => '5', 'placeholder' => 'Define your problem & suggest a solution...', 'required'=>'true' )) !!}
    </div>
</div>

{!! Form::hidden('draft', null, ['id' => 'draft_flag']) !!}
        <!-- Buttons -->
<div class="form-group no-margin">
    <div class="col-sm-10 col-sm-offset-2">
        {!! Form::submit('Submit', array('class' => 'btn btn-success')) !!}
        {!! link_to(route('rfis.store'), 'Save Draft', array('class' => 'btn btn-info btn-spacer-left')) !!}
        {!! link_to('rfis', 'Cancel', array('class' => 'btn btn-default btn-spacer-left')) !!}
    </div>
</div>
{!! Form::close() !!}

@section('endbody')
    @parent
    <script type="text/javascript" src="{!! asset('/js/jquery.currency.js') !!}"></script>
    <script type="text/javascript">
        $(document).ready(function(){
            //Date selector
            $("#date").datepicker({
                changeMonth: true,
                changeYear: true
            });
            // Currency format
            $('#cost_impact_qty').blur(function () {
                $('#cost_impact_qty').currency({decimals: 2});
            });
        });
    </script>
@endsection
