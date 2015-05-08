<ul class="sidebar-nav">
  <!-- USER LISTS -->
  <li class="nav-header"><span class="glyphicon glyphicon-list"></span> My Lists</li>
  <li>{!! link_to('tasks', 'All Tasks', array('class'=>(Request::is('tasks') ? 'active' : '') )) !!}</li> 
  @foreach($lists as $list)
    <li>{!! link_to('tasks/'.$list->listcode, $list->list, array('class'=>(Request::is('*'.$list->listcode) ? 'active' : '') )) !!}</li>
  @endforeach
  <div class="form-group" id="list_name" style="margin:6px 10px;display:none;">
    {!! Form::open(array('url' => '/tasks/list/create', 'method' => 'post', 'class' => 'form-horizontal')) !!}
    {!! Form::text('list_name', null, array('id'=>'list_name_input', 'class' => 'form-control', 'placeholder' => 'List name', 'autocomplete'=>'off', 'title'=>'Press Enter to submit.' )) !!}
    {!! Form::close() !!}
  </div>
  <li>
    <span class="btn btn-link-light btn-xs" id="new-list-btn" title="Add a new list." style="padding:6px 0;margin-left:15px;" onClick="$('#list_name').show();$('#list_name_input').focus();"><span class="glyphicon glyphicon-plus"></span> Add List</span>
  </li>
      
  <!-- FOLLOWING -->
  <br>
  <li class="nav-header"><span class="glyphicon glyphicon-eye-open"></span> Following</li>
  <li><a href=""><img src="{!! Auth::user()->gravatar !!}" class="avatar_xs" />{!! Auth::User()->name !!}</a></li>
  <li><a href=""><img src="{!! Auth::user()->gravatar !!}" class="avatar_xs" />John Doe1</a></li>
  <li><a href=""><img src="{!! Auth::user()->gravatar !!}" class="avatar_xs" />John Doe2</a></li>
</ul>