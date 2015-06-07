<div class="form-inline table-filters">
    <a href="/projects/create" type="button" class="btn btn-success pull-right"><span class="glyphicon glyphicon-plus" aria-hidden="true"></span> New Project</a>
    <div class="form-group">
        {!! Form::text('search', null, array('id'=>'search', 'class' => 'form-control', 'style'=>'min-width:250px;', 'placeholder' => 'Search...' )) !!}
    </div>
    <div class="btn-group">
        <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown">Open <span class="caret"></span></button>
        <ul class="dropdown-menu" role="menu">
            <li><a href="#">Open</a></li>
            <li><a href="#">Archived</a></li>
        </ul>
      </div>
</div>