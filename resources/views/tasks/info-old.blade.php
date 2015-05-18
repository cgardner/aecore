<script type="text/javascript">
  
  $('#comment').keypress(function(e){
     if(e.which == 13){
        taskComment('<?php echo $taskdata->code; ?>');
     }
  });
  
  $(document).ready(function(){
      
    // Scroll to bottom of comments
    $(function () {
        var comments = $('#task-comments');
        var height = comments[0].scrollHeight;
        comments.scrollTop(height);
    });

      
   
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
          task_list_add('<?php echo $taskdata->code; ?>', ui.item.value, ui.item.label);
          $(event.target).val("");
        }
        return false;// Prevent the widget from inserting the value.
      }
    }).data("ui-autocomplete")._renderItem = function(ul, item) {
        return $('<li></li>')
        .append('<a><span style="margin:0 0 2px 0;">' + item.label + '</span>' )
        .appendTo(ul);
      };
  });
</script>


    <div class="form-group">
      <label class="col-xs-1 control-label control-label-lg"><span class="glyphicon glyphicon-pushpin"></span></label>
      <div class="col-xs-11">
        {!! Form::text('term_lists', null, array('id'=>'term_lists', 'class'=>'form-control', 'placeholder'=>'Pin to lists...')) !!}
        <div id="lists">
          @foreach($tasklists as $list)
            <span id="list-{!! $list->listcode !!}" class="label label-warning label-lg" style="display:inline-block;margin:5px 5px 0 0;">{!! $list->list !!} <span class="glyphicon glyphicon-remove pointer small" onClick="task_list_remove('<?php echo $taskdata->code; ?>', '<?php echo $list->listcode; ?>');" title="Remove list from task."></span></span>
          @endforeach
        </div>
      </div>
    </div>
  {!! Form::close() !!}

  {!! Form::open(array('id'=>'task_attachments_upload', 'method' => 'post', 'class' => 'form-horizontal', 'files' => true)) !!}
    <div class="form-group no-margin">
      <label class="col-xs-1 control-label control-label-lg"><span class="glyphicon glyphicon-paperclip"></span></label>
      <div class="col-xs-11">
        <div class="file_upload">
          <script type="text/javascript">
            <?php $timestamp = time();?>
            $(function() {
              $('#file').uploadifive({
                'multi'   : true,
                'height'  : 33,
                'formData'    : {
                  'timestamp' : '<?php echo $timestamp;?>',
                  'token'     : '<?php echo md5('unique_salt' . $timestamp);?>'
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
                    url: '/tasks/attachment/add/<?php echo $taskdata->code; ?>',
                    data: $('#task_attachments_upload').serialize(),
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

  
  

<div class="task-info-activity" id="task-comments">
  <?php $useravatar = new App\Models\Useravatar; ?>
  @foreach($activitys AS $activity)
  <div class="task-comment">
    <img src="{!! $useravatar->getUserAvatar($activity->user_id, 'sm') !!}" class="avatar_sm" />
    <p class="task-comment-line1">
      <span class="pull-right text-muted small">{!! Timezone::convertFromUTC($activity->created_at, Auth::user()->timezone, 'M d') !!}</span>
      <a href="" class="bold" title="View {!! $activity->name !!}'s profile.">{!! $activity->name !!}</a>
    </p>
    @if($activity->comment_type == 'activity')
    <p class="task-comment-line2 text-muted small" style="margin-top:3px;">{!! $activity->comment !!}</p>  
    @else
    <p class="task-comment-line2">{!! $activity->comment !!}</p>  
    @endif
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