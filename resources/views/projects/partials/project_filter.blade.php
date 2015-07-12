<div class="form-inline table-filters">
    <a href="/projects/create" type="button" class="btn btn-success pull-right"><span class="glyphicon glyphicon-plus" aria-hidden="true"></span> New Project</a>
    {!! Form::text('search', null, array('id'=>'search', 'class' => 'form-control mobile-hide', 'style'=>'min-width:250px;', 'placeholder' => 'Search...' )) !!}
    <div class="btn-group btn-spacer-left">
        <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown">{{ Session::get('projectFilter') }} <span class="caret"></span></button>
        <ul class="dropdown-menu" role="menu">
            <li role="presentation" class="dropdown-header">My Projects</li>
            <li>{!! link_to('projects?s=All+Active', 'All Active') !!}</li>
            <li>{!! link_to('projects?s=Bid', 'Bid') !!}</li>
            <li>{!! link_to('projects?s=Pre-construction', 'Pre-construction') !!}</li>
            <li>{!! link_to('projects?s=Under+Construction', 'Under Construction') !!}</li>
            <li class="divider"></li>
            <li>{!! link_to('projects?s=Archived', 'Archived') !!}</li>
        </ul>
    </div>
</div>