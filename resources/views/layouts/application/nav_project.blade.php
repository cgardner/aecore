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
            @foreach($projects as $project)
                @if($activeProject->id != $project->id)
                    <li>
                        {!! link_to_route('projects.show', '#' . $project->number . ' ' . $project->name, ['project' => $project->id]) !!} 
                    </li>
                @endif
            @endforeach
        </ul>
    </div>
    
    <ul class="nav sidebar-nav">
        <li class="nav-header">Project Navigation</li>
        @foreach($navigation as $link)
            <li>
                <a href="{!! $link['url'] !!}" class="{{ \Request::url() == $link['url'] ? 'active' : null }}">
                    <span class="glyphicon {{ $link['icon'] }}"></span> {{ $link['title'] }}
                </a>
            </li>
        @endforeach
    </ul>
</div>
