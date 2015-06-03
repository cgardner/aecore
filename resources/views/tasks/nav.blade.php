<script type="text/javascript" src="{!! asset('/js/tasks.js') !!}"></script>
<script type="text/javascript">
  $(function(){
    $('input[type=text][name=list_name]').tooltip({
      placement: "bottom",
      trigger: "focus"
    });    
  });
</script>

<ul class="sidebar-nav">
  <!-- USER LISTS -->
  <li class="nav-header"><span class="glyphicon glyphicon-list"></span> My Lists</li>
  <li>{!! link_to('tasks', 'All Tasks', array('class'=>(Request::is('tasks') ? 'active' : '') )) !!}</li> 
  @foreach($lists as $list)
    <li id="li-list-{!! $list->listcode !!}" onmouseover="$('#li-list-remove-<?php echo $list->listcode; ?>').show();" onmouseout="$('#li-list-remove-<?php echo $list->listcode; ?>').hide();"><a id="li-a-list-{!! $list->listcode !!}" href="/tasks/{!! $list->listcode !!}" class="{!! Request::is('*'.$list->listcode) ? 'active' : '' !!}">{!! $list->list !!} <span id="li-list-remove-{!! $list->listcode !!}" class="glyphicon glyphicon-remove-sign pull-right text-muted text-hover-danger" title="Remove list." style="margin-top:2px;display:none;" onClick="removeTasklist('<?php echo $list->listcode; ?>', '<?php echo Session::get('listcode'); ?>');event.preventDefault();"></span></a></li>
  @endforeach
  <div class="form-group" id="list_name" style="margin:6px 10px;display:none;">
    {!! Form::open(array('url' => '/tasks/list/create', 'method' => 'post', 'class' => 'form-horizontal')) !!}
    {!! Form::text('list_name', null, array('id'=>'list_name_input', 'class' => 'form-control', 'onBlur' => '$(\'#list_name\').hide()', 'placeholder' => 'List name', 'autocomplete'=>'off', 'title'=>'Press Enter to submit.' )) !!}
    {!! Form::close() !!}
  </div>
  <li class="divider"></li>
  <li>
    <span class="btn btn-link-light btn-xs" id="new-list-btn" title="Add a new list." style="padding:0;margin-left:15px;" onClick="$('#list_name').show();$('#list_name_input').focus();"><span class="glyphicon glyphicon-plus"></span> Add List</span>
    <span class="btn btn-link-light btn-xs" id="new-list-btn" title="View your deleted lists & tasks." style="padding:0;margin-left:10px;" onClick="window.location='/tasks/trash';"><span class="glyphicon glyphicon-trash"></span> Trash</span>
  </li>
      
  <!-- FOLLOWING -->
  <br>
  @if(count($lists_following) > 0)
    <li class="nav-header"><span class="glyphicon glyphicon-eye-open"></span> Following</li>
  @endif
  @foreach($lists_following as $list_following)
    <li>{!! $list_following->link !!}</li>
  @endforeach
</ul>