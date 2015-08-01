<div class="sidebar-nav-wrapper" id="projectnav">
    <span class="btn btn-primary pull-right toggle-nav" style="margin:5px 10px 0 0;padding:6px;"
         onClick="$('#projectnav').toggle();">
       <span class="glyphicon glyphicon-menu-hamburger" style="margin:0;"></span>
    </span>
    
    <div class="btn-group" style="width:100%;">
        <button class="btn btn-default btn-block dropdown-toggle sidebar-project-list" data-toggle="dropdown">
            #{{ $activeProject->number . ' ' . $activeProject->name }}
            <span class="caret"></span>
        </button>
        <ul class="dropdown-menu sidebar-project-list-dropdown" role="menu">
            @if(count($projects) <= 1)
                <span style="margin-left:12px;" class="glyphicon glyphicon-warning-sign small text-muted"></span><span class="text-danger btn-spacer-left bold">No projects found.</span>
            @endif
            @foreach($projects as $project)
                @if($activeProject->id != $project->id)
                    <li>
                        {!! link_to_route('projects.show', '#' . $project->number . ' ' . $project->name, ['project' => $project->id]) !!} 
                    </li>
                @endif
            @endforeach
            <li class="divider"></li>
            <li><a href="/projects/create"><span class="glyphicon glyphicon-plus small"></span> New Project</a></li>
        </ul>
    </div>
    
    <ul class="nav sidebar-nav">
        <li class="nav-header">Project Navigation</li>
        @foreach($navigation as $link)
            <li>
                <a href="{!! $link['url'] !!}" class="{{ \Request::url() == $link['url'] ? 'active' : null }}">
                    <span class="fa fa-fw {{ $link['icon'] }}"></span> {{ $link['title'] }}
                </a>
            </li>
        @endforeach
    </ul>
</div>
