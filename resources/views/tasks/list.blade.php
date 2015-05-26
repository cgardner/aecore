@extends('layouts.application.main_wide')
@section('content')

<script type="text/javascript">
  $(function(){
    $('input[type=text][name=task]').tooltip({
      placement: "bottom",
      trigger: "focus"
    });    
  });
</script>

  @include('tasks.nav')
  <div class="task-list-wrapper" id="task-list">
    <!-- FILTERS -->
    <div class="pagehead">
      <div class="container-fluid">
        <div class="btn-group pull-right btn-spacer-left">
          <button type="button" class="btn btn-default btn-sm dropdown-toggle" data-toggle="dropdown">{!! Session::get('filter_text') !!} <span class="caret"></span></button>
          <ul class="dropdown-menu" role="menu">
            @if(Session::get('filter_text') == "Open Tasks")
              <li><a href="{!! '/tasks/' . Session::get('listcode') . '?filter=complete' !!}">Completed Tasks</a>
            @else
              <li><li><a href="{!! '/tasks/' . Session::get('listcode') . '?filter=open' !!}">Open Tasks</a>
            @endif
          </ul>
        </div>
        @if($completed_count > 0 && Session::get('filter_text') != "Completed Tasks")
          <a href="/tasks/refresh" class="btn btn-sm btn-default pull-right btn-spacer-left" title="Refresh list to clear completed tasks."><span class="glyphicon glyphicon-refresh"></span> Clear Completed</a>
        @endif
        <h1>{!! $listname !!}</h1>
      </div>
    </div>
    
    <div class="container-fluid">
      <!-- NEW TASK INPUT -->
      {!! Form::open(array('url' => '/tasks/create', 'method' => 'post', 'class' => 'form-horizontal')) !!}
      <div class="form-group" style="margin-bottom:15px;">
        <div class="col-md-12">
          {!! Form::text('task', null, array('class' => 'form-control', 'placeholder' => 'Add a task...', 'autocomplete'=>'off', 'required'=>'true', 'autofocus'=>'true', 'title'=>'Press Enter to submit.')) !!}
        </div>
      </div>
      {!! Form::close() !!}

      @if(count($mytasks) == 0)
        <div class="alert alert-info">
          <p><span class="glyphicon glyphicon-exclamation-sign"></span> <strong>No {!! Session::get('filter_text') !!} found in "{!! $listname !!}".</strong></p>
          <p>Enter a task above to get started.</p>
        </div>
      @endif
    </div>
    
    <!-- USER TASK LIST -->
    @foreach($mytasks as $mytask)
    <div class="taskline col-md-12" id="taskline-{!! $mytask->taskcode !!}">
      @if($mytask->status == 'complete')
        <span class="taskline-checkbox-complete" id="task-checkbox-{!! $mytask->taskcode !!}" title="Reopen this task." onClick="updateTask('<?php echo $mytask->taskcode; ?>', 'open');"></span>
      @else
        <span class="taskline-checkbox" id="task-checkbox-{!! $mytask->taskcode !!}" title="Complete this task." onClick="updateTask('<?php echo $mytask->taskcode; ?>', 'complete');"></span>
      @endif
      <div class="btn-group task-btn-group">
        <button data-toggle="dropdown" class="btn btn-{!! $mytask->priority !!} dropdown-toggle task-priority-tag" title="Change task priority." type="button"><span class="caret" style="margin-top:-7px;"></span></button>
        <ul class="dropdown-menu task-priority-list">
          <li><a href="{!! URL::to('tasks/priority/3/' . $mytask->taskcode) !!}"><span class="label label-danger">High Priority</span></a></li>
          <li><a href="{!! URL::to('tasks/priority/2/' . $mytask->taskcode) !!}"><span class="label label-warning">Medium Priority</span></a></li>
          <li><a href="{!! URL::to('tasks/priority/1/' . $mytask->taskcode) !!}"><span class="label label-info">Low Priority</span></a></li>
        </ul>
      </div>
      <div class="taskline-input-wrapper">
        @if($mytask->list != "")
          <a href="{!! URL::to('tasks/' . $mytask->listcode) !!}" id="list-tag-{!! $mytask->taskcode !!}" class="task_tags task_project">{!! $mytask->list !!}</a>
        @endif
        @if($mytask->date_due != "")
          <span id="task-date-{!! $mytask->taskcode !!}" class="task_tags task_date">{!! $mytask->date_due !!}</span>
        @endif
        <input type="text" class="form-control taskline-input <?php if($mytask->status == 'complete') { echo 'strike'; } ?>" id="task-text-{!! $mytask->taskcode !!}" value="{!! htmlspecialchars($mytask->task) !!}" onFocus="$('div').removeClass('taskline-active');$('#taskline-<?php echo $mytask->taskcode; ?>').addClass('taskline-active');showTask('<?php echo $mytask->taskcode; ?>');" onBlur="updateTask('<?php echo $mytask->taskcode; ?>', 'task');" onkeyup="$('#task-text-info').html(this.value);"/>
      </div>
    </div>
    @endforeach
  </div>
  <div class="task-info-wrapper" id="task-details"></div>
@endsection 