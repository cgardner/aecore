<script type="text/javascript">
    $(document).ready(function () {
        $('input#search').quicksearch('div#project-search');
    });
</script>

@if(count($projectUsers) == 0)
  <div class="alert alert-info">
    <p class="bold">No projects were found.</p>
    <p>Try changing your filter or create a <a href="/projects/create" class="btn btn-success btn-xs bold"><span class="glyphicon glyphicon-plus"></span> New Project</a> to get started.</p>
  </div>
@else
  @foreach($projectUsers as $projectUser)
    <div class="project-listing" id="project-search" onmouseover="$('#<?php echo $projectUser->project_id; ?>').show
            ();" onmouseout="$('#<?php echo $projectUser->project_id; ?>').hide();">
      <span class="project-tile-image default" style="cursor:default;"></span>
      <div class="project-listing-data">
        @if($projectUser->access == App\Models\Projectuser::ACCESS_ADMIN)
            <a href="{!! URL::route('projects.edit', ['project' => $projectUser->project->id]) !!}" class="btn btn-xs btn-default pull-right btn-spacer-left"><span class="glyphicon glyphicon-pencil"></span> Edit Project</a>
            <span class="text-muted pull-right small" style="margin-top:3px;"><span class="glyphicon glyphicon-tower small"></span> Admin</span>
        @endif
        <h4>{!! link_to_route('projects.show', $projectUser->project->number . ' ' . $projectUser->project->name, ['project' => $projectUser->project->id], ['class' => 'bold']) !!}</h4>
        <p class="text-muted">{{ $projectUser->project->street . ' | ' . $projectUser->project->city . ', ' . $projectUser->project->state . ' ' . $projectUser->project->zip_code }}</p>
        <div class="project-listing-description" id="project-description">{{ $projectUser->project->description }}</div>
        <span class="text-muted pull-left"><small>{{ $projectUser->project->size ? number_format($projectUser->project->size, 0, '.', ',') . ' ' . $projectUser->project->size_unit : 'N/A' }}</small></span>
        <span class="text-muted pull-left" style="margin-left:8px;"><small>${{ number_format($projectUser->project->value, 0, '.', ',') }}</small></span>
        <span class="text-muted pull-left" style="margin-left:8px;">
          <small>
            <span class="glyphicon glyphicon-star-empty"></span>Start: {{ $projectUser->project->start }}
          </small>
        </span>
        <span class="text-muted pull-left" style="margin-left:8px;">
          <small>
            <span class="glyphicon glyphicon-star"></span>Finish: {{ $projectUser->project->finish }}
          </small>
        </span>
      </div>
    </div>
  @endforeach
@endif