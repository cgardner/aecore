
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
