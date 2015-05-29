<script type="text/javascript">
  
  // Submit comment on enter
  $('#comment').keypress(function(e){
     if(e.which == 13){
        taskComment('<?php echo $taskdata->taskcode; ?>');
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
  
    // Scroll to bottom of comments
    $(function () {
        var comments = $('#task-comments');
        var height = comments[0].scrollHeight;
        comments.scrollTop(height);
    });
  
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
        .append('<a>' + item.file + '<span class="bold" style="margin:0 0 2px 0;">' + item.label + '</span><br><span class="text-muted small" style="margin:0;">' + item.title + '</span>' )
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
        .append('<a>' + item.file + '<span class="bold" style="margin:0 0 2px 0;">' + item.label + '</span><br><span class="text-muted small" style="margin:0;">' + item.title + '</span>' )
        .appendTo(ul);
      };      
      
    //Find task lists
    var NoResultsLabel = "No results found.";
    $('#term_lists').autocomplete({
      source: function(request, response) {    
        $.ajax({ url: "/autocomplete/tasklists",
          data: {term: $("#term_lists").val()},
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
          $("#term_lists").val(ui.item.label);
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
          updateTask('<?php echo $taskdata->taskcode; ?>', 'addList', ui.item.value);
          $(event.target).val("");
        }
        return false;// Prevent the widget from inserting the value.
      }
    }).data("ui-autocomplete")._renderItem = function(ul, item) {
        return $('<li></li>')
        .append('<a><span style="margin:0 0 2px 0;">' + item.label + '</span>')
        .appendTo(ul);
      };
      
  });
</script>

<div class="task-info-details">
  @if($taskdata->user_id == Auth::User()->id)
    <span class="btn-link pull-right small pointer" title="There's no going back!" onClick="updateTask('{!! $taskdata->taskcode !!}', 'delete');">Delete Task</span>
  @endif
  
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
          <img src="{!! Auth::user()->gravatar !!}" />{!! $taskdata->name !!}
          @if($taskdata->user_id == Auth::User()->id)
            <span class="usertag-remove"><span class="glyphicon glyphicon-remove-sign" onClick="$('#assigned_to').hide();$('#assigned_to_new').show();$('#term').focus();" title="Remove user & reassign task."></span></span>
          @endif
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
          {!! Form::text('date_due', date('m/d/Y', strtotime($taskdata->date_due)), array('id'=>'date_due', 'class' => 'form-control', 'placeholder' => 'Date due...')) !!}
        @else
          {!! Form::text('date_due', null, array('id'=>'date_due', 'class' => 'form-control', 'placeholder' => 'Date due...')) !!}
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
    
    <!-- LIST -->
    <div class="form-group">
      <label class="col-xs-1 control-label control-label-lg"><span class="glyphicon glyphicon-list"></span></label>
      <div class="col-xs-11">
        @if(count($listdata) > 0)
          <div class="usertag" id="list-{!! $listdata->taskcode !!}">
            <span style="margin-left:10px;">{!! $listdata->list !!}</span>
            <span class="usertag-remove"><span class="glyphicon glyphicon-remove-sign" onClick="updateTask('<?php echo $listdata->taskcode; ?>', 'removeList');" title="Remove list from task."></span></span>
          </div>
          {!! Form::text('term_lists', null, array('id'=>'term_lists', 'class'=>'form-control', 'style'=>'display:none;', 'placeholder'=>'Pin to list...')) !!}
        @else
          {!! Form::text('term_lists', null, array('id'=>'term_lists', 'class'=>'form-control', 'placeholder'=>'Pin to list...')) !!}
        @endif
      </div>
    </div>
  {!! Form::close() !!}
    
  {!! Form::open(array('id'=>'task_attachments', 'method' => 'post', 'class' => 'form-horizontal', 'files' => true)) !!}
    <div class="form-group no-margin">
      <label class="col-xs-1 control-label control-label-lg"><span class="glyphicon glyphicon-paperclip"></span></label>
      <div class="col-xs-11">
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
                  $('.close').remove();
                  $("#file_id_list").append('<input type="hidden" id="file_id_' + data + '" name="file_id[]" value="' + data + '"/>');
                },
                'onQueueComplete'  : function() {
                  $.ajax({
                    type: "POST",
                    url: '/tasks/attachment/add/<?php echo $taskdata->taskcode; ?>',
                    data: $('#task_attachments').serialize(),
                    success: function() {
                      //do nothing
                    }
                  });
                }
              });
            });
          </script>
          {!! Form::file("file", ["id" => "file"]) !!}
          <div id="queue" class="queue"><span class="text-muted small">Or drag & drop files here.</span></div>
          <div id="file_id_list"></div>
          <?php $s3 = AWS::get('s3'); ?>
          @foreach($attachments as $attachment)
            <div class="attachment-tile" id="attachment-{!! $attachment->file_id !!}">
              <span class="glyphicon glyphicon-remove text-danger small pointer pull-right" title="Remove attachment." onClick="task_remove_attachment('<?php echo $taskdata->code; ?>', '<?php echo $attachment->file_id; ?>');"></span>
              {!! $functionscontroller->display_file_icon($attachment->file_name) !!}
              <p class="l1">{!! $attachment->file_name !!}</p>
              <p class="l2">{!! $functionscontroller->formatBytes($attachment->file_size) !!} - <a href="{!! $s3->getObjectUrl($attachment->file_bucket, $attachment->file_path . '/' . $attachment->file_name); !!}" title="Download attachment.">Download</a></p>
            </div>
          @endforeach
        </div>
      </div>
    </div>
  {!! Form::close() !!}
  
    <div class="task-info-feed" id="task-comments">
      <?php $useravatar = new App\Models\Useravatar; ?>
      @foreach($feeds AS $feed)
      <div class="task-comment">
        <img src="{!! $useravatar->getUserAvatar($feed->user_id, 'sm') !!}" class="avatar_sm" />
        <p class="task-comment-line1">
          <span class="pull-right text-muted small">{!! Timezone::convertFromUTC($feed->created_at, Auth::user()->timezone, 'M d') !!}</span>
          <a href="" class="bold" title="View {!! $feed->name !!}'s profile.">{!! $feed->name !!}</a>
        </p>
        <p class="task-comment-line2 <?php if($feed->type == 'activity') { echo 'text-muted'; } ?>">{!! $feed->comment !!}</p>  
      </div>
      @endforeach
    </div>
    
    <div class="task-info-comment">
      <div class="form-group no-margin">
        <div class="col-xs-1">
          <img src="{!! Auth::user()->gravatar !!}" class="avatar_sm"/>
        </div>
        <div class="col-xs-11">
          {!! Form::text('comment', null, array('id'=>'comment', 'class'=>'form-control', 'placeholder'=>'Comment...')) !!}
        </div>
      </div>
    </div> 
  
</div>