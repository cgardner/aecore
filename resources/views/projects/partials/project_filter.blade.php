<div class="form-inline table-filters">
    <div class="form-group">
        {!! Form::text('search', null, array('class' => 'form-control', 'style'=>'min-width:250px;', 'placeholder' => 'Search...' )) !!}
    </div>
    <div class="btn-group">
        <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown">Test <span class="caret"></span></button>
        <ul class="dropdown-menu" role="menu">
            <li><a href="#">My Projects: Open</a></li>
            <li><a href="#">My Projects: Archived</a></li>
            <li><a href="#">All Projects: Open</a></li>
            <li><a href="#">All Projects: Archived</a></li>
        </ul>
      </div>
</div>