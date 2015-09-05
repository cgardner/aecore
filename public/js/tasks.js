function removeTasklist(listcode, session_listcode) {
  $.ajaxSetup({
    headers: { 'X-CSRF-Token' : $('meta[name=_token]').attr('content') }
  });
  $('#li-list-' + listcode).toggle('slide');
  $.ajax({
    type: "POST",
    url: '/tasks/list/remove',
    data: { listcode:listcode }
  }).then(function() {
    if(listcode == session_listcode) {
      window.location.href = '/tasks';
    }
  });
}

// Loads sidebar
function showTask(taskcode) {
  
  $.ajaxSetup({
    headers: { 'X-CSRF-Token' : $('meta[name=_token]').attr('content') }
  });
  
  $.ajax({
    type:'GET',
    url: '/tasks/details/' + taskcode,
    success: function(response) {
        
        $('#task-details').hide().html(response).fadeIn('medium')
        $('#task-list').animate({"right" : "460px"}, 150);
        
        // Scroll to bottom of comments
        var comments = $('#task-comments');
        comments.scrollTop(
            comments[0].scrollHeight
        );
    }
  });
}

// Update a task
function updateTask(taskcode, action, data) {
  
  $.ajaxSetup({
    headers: { 'X-CSRF-Token' : $('meta[name=_token]').attr('content') }
  });
  
  if(action == 'open') {
    $('#task-text-' + taskcode).removeClass('strike');
    $('#task-checkbox-' + taskcode).toggleClass('taskline-checkbox taskline-checkbox-complete');
    $('#task-checkbox-' + taskcode).attr('onClick', 'updateTask(\'' + taskcode + '\', \'complete\');tglClearBtn(\'up\');');
    if($('#task-details').css('display') == 'block'){
      $('#task-checkbox-info-' + taskcode).toggleClass('taskline-checkbox taskline-checkbox-complete');
      $('#task-checkbox-info-' + taskcode).attr('onClick', 'updateTask(\'' +  taskcode + '\', \'complete\');tglClearBtn(\'up\');');
    }
    var type = 'status';
    var data = 'open';
  }
  
  if(action == 'complete') {
    $('#task-text-' + taskcode).addClass('strike');
    $('#task-checkbox-' + taskcode).toggleClass('taskline-checkbox taskline-checkbox-complete');
    $('#task-checkbox-' + taskcode).attr('onClick', 'updateTask(\'' + taskcode + '\', \'open\');tglClearBtn(\'down\');');
    if($('#task-details').css('display') == 'block'){
      $('#task-checkbox-info-' + taskcode).toggleClass('taskline-checkbox taskline-checkbox-complete');
      $('#task-checkbox-info-' + taskcode).attr('onClick', 'updateTask(\'' + taskcode + '\', \'open\');tglClearBtn(\'down\');');
    }
    var type = 'status';
    var data = 'complete';
  }
  
  if(action == 'delete') {
    var type = 'status';
    var data = 'disabled';
    $('#task-details').hide();
    $('#task-list').css('right', '0');
    $('#taskline-'+taskcode).hide();
  }
   
  if(action == 'task') {
    var type = 'task';
    var data = $('#task-text-' + taskcode).val();
  }
   
  if(action == 'assign') {
    var type = 'user_id';
  }
   
  if(action == 'date') {
    var type = 'date_due';
    var data = $('#date_due').val();
    if(data != '') {
      $('#loader-line-date').html('<p style="margin:5px 0 0 0;padding:0;"><span class="loader-infinity"></span> Saving...</p>');
    }
  }
  
  if(action == 'removeList') {
    var type = 'tasklist_id';
    var data = '0';
  }
  
  if(action == 'addList') {
    var type = 'tasklist_id';
  }
  
  if(data != "") {
    $.ajax({
      type: "POST",
      url: '/tasks/update',
      data: {taskcode:taskcode, type:type, data:data},
      success: function() {
        if(action == 'assign' || action == 'addList') {
          showTask(taskcode);
        }
        if(action == 'date') {
          setTimeout(function() { 
            $('#loader-line-date').html(''); 
          }, 500);
        }
        if(action == 'removeList') {
          $('#list-tag-'+taskcode).hide();
          $('#list-'+taskcode).hide();
          $('#term_lists').show();
          $('#term_lists').focus();
        }
      }
    });
  }
}

// Task followers
function addFollower(taskcode, user_id, name) {
  $.ajaxSetup({
    headers: { 'X-CSRF-Token' : $('meta[name=_token]').attr('content') }
  });
  
  $.ajax({
    type: "POST",
    url: '/tasks/follower',
    data: {taskcode:taskcode, user_id:user_id, status:'active'},
    success: function() {
      $('#followers').append('<span id="follower-' + taskcode + user_id + '"  class="label label-info label-lg" style="display:inline-block;margin:5px 5px 0 0;">' + name + ' <span class="glyphicon glyphicon-remove pointer small" onClick="$(\'#follower-' + taskcode + user_id + '\').remove();" title="Remove user & reassign task."></span></span>');
    }
  });
}

function removeFollower(taskcode, user_id) {
  $.ajaxSetup({
    headers: { 'X-CSRF-Token' : $('meta[name=_token]').attr('content') }
  });
  
  $.ajax({
    type: "POST",
    url: '/tasks/follower',
    data: {taskcode:taskcode, user_id:user_id, status:'disabled'},
    success: function() {
      $('#follower-' + taskcode + user_id).remove();
    }
  });
}

function taskComment(taskcode) {
  $.ajaxSetup({
    headers: { 'X-CSRF-Token' : $('meta[name=_token]').attr('content') }
  });
  
  var comment = $('#comment').val();
  $.ajax({
    type: "POST",
    url: '/tasks/comment',
    data: {taskcode:taskcode, comment:comment},
    success: function() {
      showTask(taskcode);
    }
  });
}

function removeTaskAttachment(taskcode, file_id) {
  $.ajaxSetup({
    headers: { 'X-CSRF-Token' : $('meta[name=_token]').attr('content') }
  });
  
  $.ajax({
    type: "POST",
    url: '/tasks/attachment/remove/'+taskcode,
    data: {file_id:file_id},
    success: function() {
      $('#attachment-' + file_id).remove();
    }
  });
}

function tglClearBtn(direction) {
        
    var clrCount = $('#completed_count').val();

    if(direction == 'up') {
        var newCount = parseInt(clrCount) + 1;
        $('#completed_count').val(newCount);
    } else {
        var newCount = parseInt(clrCount) - 1;
        $('#completed_count').val(newCount);
    }

    if($('#completed_count').val() > 0) {
        $('#clearBtn').show();
    } else {
        $('#clearBtn').hide();
    }
}