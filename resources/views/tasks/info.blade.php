<script type="text/javascript">
  
  $('#comment').keypress(function(e){
     if(e.which == 13){
        taskComment('<?php echo $taskdata->code; ?>');
     }
  });

  //Change date due
  $("#date_due").datepicker({
    changeMonth: true,
    changeYear: true,
    onClose: function() { 
      updateTask('<?php echo $taskdata->taskcode; ?>', 'date');
    }
  });
    
  $(document).ready(function(){         
    //Find assign users
    var NoResultsLabel = "No results found.";
    $('#term').autocomplete({
      source: function(request, response) {    
        $.ajax({ url: "/autocomplete/users",
          data: {term: $("#term").val()},
          dataType: "json",
          type: "POST",
          success: function(data){
            if(!data.length){
              var result = [{
                label: NoResultsLabel,
                title: '',
                value: response.term,
                file: ''
              }];
               response(result);
             } else {
              response(data);
            }
          }
        });
      },
      minLength:1,
      focus: function(event, ui) {
        if (ui.item.label === NoResultsLabel) {
          event.preventDefault();
        } else {
          $("#term").val(ui.item.label);
        }
        return false; // Prevent the widget from inserting the value.
      },
      change: function (event, ui) {
        if(!ui.item){
          $(event.target).val("");
        }
      },
      select: function(event, ui) {
        if (ui.item.label === NoResultsLabel) {
          $(event.target).val("");
        } else {
          updateTask('<?php echo $taskdata->taskcode; ?>', 'assign', ui.item.value);
          $(event.target).val("");
        }
        return false;// Prevent the widget from inserting the value.
      }
    }).data("ui-autocomplete")._renderItem = function(ul, item) {
        return $('<li></li>')
        .append('<a>' + item.avatar + '<span class="bold" style="margin:0 0 2px 0;">' + item.label + '</span><br><span class="text-muted small" style="margin:0;">' + item.title + '</span>' )
        .appendTo(ul);
      };
    
    // Followers
    var NoResultsLabel = "No results found.";
    $('#term_followers').autocomplete({
      source: function(request, response) {    
        $.ajax({ url: "/autocomplete/users",
          data: {term: $("#term_followers").val()},
          dataType: "json",
          type: "POST",
          success: function(data){
            if(!data.length){
              var result = [{
                label: NoResultsLabel,
                title: '',
                value: '',
                file: ''
              }];
               response(result);
             } else {
              response(data);
            }
          }
        });
      },
      minLength:1,
      focus: function(event, ui) {
        if (ui.item.label === NoResultsLabel) {
          event.preventDefault();
        } else {
          $("#term_followers").val(ui.item.label);
        }
        return false; // Prevent the widget from inserting the value.
      },
      change: function (event, ui) {
        if(!ui.item){
          $(event.target).val("");
        }
      },
      select: function(event, ui) {
        if (ui.item.label === NoResultsLabel) {
          $(event.target).val("");
        } else {
          addFollower('<?php echo $taskdata->taskcode; ?>', ui.item.value, ui.item.label);
          $(event.target).val("");
        }
        return false;// Prevent the widget from inserting the value.
      }
    }).data("ui-autocomplete")._renderItem = function(ul, item) {
        return $('<li></li>')
        .append('<a>' + item.avatar + '<span class="bold" style="margin:0 0 2px 0;">' + item.label + '</span><br><span class="text-muted small" style="margin:0;">' + item.title + '</span>' )
        .appendTo(ul);
      };      
  });
</script>

<div class="task-info-details">
  <span class="btn-link pull-right small pointer" title="There's no going back!" onClick="updateTask('{!! $taskdata->taskcode !!}', 'delete');">Delete Task</span>
  <div class="form-group">
    @if($taskdata->status == 'complete')
      <span class="taskline-checkbox-complete no-margin" id="task-checkbox-info-{!! $taskdata->taskcode !!}" title="Reopen this task." onClick="updateTask('{!! $taskdata->taskcode !!}', 'open');"></span>
    @else
      <span class="taskline-checkbox no-margin" id="task-checkbox-info-{!! $taskdata->taskcode !!}" title="Mark as complete." onClick="updateTask('{!! $taskdata->taskcode !!}', 'complete');"></span>  
    @endif
    <h1 id="task-text-info">{!! $taskdata->task !!}</h1>
  </div>
  
  {!! Form::open(array('method'=>'post', 'class'=>'form-horizontal', 'onSubmit'=>'return false')) !!}
    <!-- ASSIGNED TO -->
    <div class="form-group">
      <label class="col-xs-1 control-label control-label-lg"><span class="glyphicon glyphicon-user"></span></label>
      <div class="col-xs-11" id="assigned_to">
        <div class="usertag">
          <img src="{!! Auth::user()->gravatar !!}" />{!! $taskdata->name !!}<span class="usertag-remove"><span class="glyphicon glyphicon-remove-sign" onClick="$('#assigned_to').hide();$('#assigned_to_new').show();$('#term').focus();" title="Remove user & reassign task."></span></span>
        </div>
      </div>
      <div class="col-xs-11" id="assigned_to_new" style="display:none;">
        {!! Form::text('term', null, array('id'=>'term', 'class'=>'form-control', 'placeholder'=>'Assign task to...')) !!}
      </div>
    </div>
  
    <!-- DATE DUE -->
    <div class="form-group">
      <label class="col-xs-1 control-label control-label-lg" for="date_due"><span class="glyphicon glyphicon-calendar"></span></label>
      <div class="col-xs-6">
        @if($taskdata->date_due != null)
          {!! Form::text('date_due', date('m/d/Y', strtotime($taskdata->date_due)), array('id'=>'date_due', 'class' => 'form-control', 'placeholder' => 'Date required...')) !!}
        @else
          {!! Form::text('date_due', null, array('id'=>'date_due', 'class' => 'form-control', 'placeholder' => 'Date required...')) !!}
        @endif
        <div id="loader-line-date"></div>
      </div>
    </div>
    
    <!-- FOLLOWERS -->
    <div class="form-group">
      <label class="col-xs-1 control-label control-label-lg"><span class="glyphicon glyphicon-eye-open"></span></label>
      <div class="col-xs-11">
        {!! Form::text('term_followers', null, array('id'=>'term_followers', 'class'=>'form-control', 'placeholder'=>'Add followers...')) !!}
        <div id="followers">
          @foreach($taskfollowers as $follower)
            <span id="follower-{!! $follower->taskcode . $follower->user_id !!}" class="label label-info label-lg" style="display:inline-block;margin:5px 5px 0 0;">{!! $follower->name !!} <span class="glyphicon glyphicon-remove pointer small" onClick="removeFollower('<?php echo $follower->taskcode; ?>', '<?php echo $follower->user_id; ?>');" title="Remove user from task."></span></span>
          @endforeach
        </div>
      </div>
    </div>
    
  {!! Form::close() !!}
</div>