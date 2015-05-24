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
        <h1>{!! $user->name !!}</h1>
      </div>
    </div>
    
    <!-- USER TASK LIST -->
    @foreach($tasks as $task)
    <div class="taskline col-md-12" id="taskline-{!! $task->taskcode !!}">
      @if($task->status == 'complete')
        <span class="taskline-checkbox-complete" id="task-checkbox-{!! $task->taskcode !!}" title="Reopen this task." onClick="updateTask('<?php echo $task->taskcode; ?>', 'open');"></span>
      @else
        <span class="taskline-checkbox" id="task-checkbox-{!! $task->taskcode !!}" title="Complete this task." onClick="updateTask('<?php echo $task->taskcode; ?>', 'complete');"></span>
      @endif
      <div class="btn-group task-btn-group">
        <button data-toggle="dropdown" class="btn btn-{!! $task->priority !!} dropdown-toggle task-priority-tag" title="Change task priority." type="button"><span class="caret" style="margin-top:-7px;"></span></button>
        <ul class="dropdown-menu task-priority-list">
          <li><a href="{!! URL::to('tasks/priority/3/' . $task->taskcode) !!}"><span class="label label-danger">High Priority</span></a></li>
          <li><a href="{!! URL::to('tasks/priority/2/' . $task->taskcode) !!}"><span class="label label-warning">Medium Priority</span></a></li>
          <li><a href="{!! URL::to('tasks/priority/1/' . $task->taskcode) !!}"><span class="label label-info">Low Priority</span></a></li>
        </ul>
      </div>
      <div class="taskline-input-wrapper">
        @if($task->list != "")
          <a href="{!! URL::to('tasks/' . $task->listcode) !!}" id="list-tag-{!! $task->taskcode !!}" class="task_tags task_project">{!! $task->list !!}</a>
        @endif
        @if($task->date_due != "")
          <span id="task-date-{!! $task->taskcode !!}" class="task_tags task_date">{!! $task->date_due !!}</span>
        @endif
        <input type="text" class="form-control taskline-input <?php if($task->status == 'complete') { echo 'strike'; } ?>" id="task-text-{!! $task->taskcode !!}" value="{!! htmlspecialchars($task->task) !!}" onFocus="$('#taskline-<?php echo $task->taskcode; ?>').addClass('taskline-active');showTask('<?php echo $task->taskcode; ?>');" onBlur="updateTask('<?php echo $task->taskcode; ?>', 'task');$('#taskline-<?php echo $task->taskcode; ?>').removeClass('taskline-active');" onkeyup="$('#task-text-info').html(this.value);"/>
      </div>
    </div>
    @endforeach
  </div>
  <div class="task-info-wrapper" id="task-details"></div>
@endsection 