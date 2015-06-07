<script type="text/javascript">
    $(document).ready(function () {
        $('input#search').quicksearch('div#project-search');
    });
</script>

@if(count($projects) == 0)
  <div class="alert alert-info">
    <p class="bold">No projects were found.</p>
    <p>Try changing your filter or create a <a href="/projects/create" class="btn btn-success btn-xs bold"><span class="glyphicon glyphicon-plus"></span> New Project</a> to get started.</p>
  </div>
@else
  @foreach($projects as $project)
    <div class="project-listing" id="project-search" onmouseover="$('#<?php echo $project->id; ?>').show();" onmouseout="$('#<?php echo $project->id; ?>').hide();">
      <span class="project-tile-image default" style="cursor:default;"></span>
      <div class="project-listing-data">
        @if($project->access == 'admin')
            {!! link_to_route('projects.edit', 'Edit', ['project' => $project->id], array('class' => 'btn btn-xs btn-default pull-right')) !!}
        @endif
        <h4>{!! link_to_route('projects.show', $project->number . ' ' . $project->name, ['project' => $project->id], ['class' => 'bold']) !!}</h4>
        <p class="text-muted">{!! @$project->street . ' | ' . $project->city . ', ' . $project->state . ' ' . $project->zip_code !!}</p>
        <div class="project-listing-description" id="project-description">{!! $project->description !!}</div>
        <span class="text-muted pull-left"><small>{!! $project->size ? number_format($project->size, 0, '.', ',') . ' ' . $project->size_unit : 'N/A' !!}</small></span>
        <span class="text-muted pull-left" style="margin-left:8px;"><small>${!! number_format($project->value, 0, '.', ',') !!}</small></span>
        <span class="text-muted pull-left" style="margin-left:8px;"><small><span class="glyphicon glyphicon-star-empty"></span>Start: </small></span>
        <span class="text-muted pull-left" style="margin-left:8px;"><small><span class="glyphicon glyphicon-star"></span>Finish: </small></span>
      </div>
    </div>
  @endforeach
@endif