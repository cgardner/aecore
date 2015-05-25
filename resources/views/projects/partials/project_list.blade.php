@if(count($projects) == 0)
  <div class="alert alert-info">
    <p class="bold">No projects were found.</p>
    <p>Try changing your filter or create a <a href="/projects/create" class="btn btn-success btn-xs bold"><span class="glyphicon glyphicon-plus"></span> New Project</a> to get started.</p>
  </div>
@else
  <div class="panel panel-default">
    <div class="panel-body" style="padding:0;">
      <table class="table table-hover table-sortable no-margin">
        <thead>
          <th style="text-align:right;">#</th>
          <th>Project</th>
          <th class="tablet-hide">Address</th>
          <th class="mobile-hide">Size</th>
          <th class="mobile-hide">Value</th>
          <th class="mobile-hide">Status</th>
          <th></th>
        </thead>
        <tbody>
          @foreach($projects as $project)
          <tr>
            <td class="project-number">{!! $project->number !!}</td>
            <td>
                {!! link_to_route('projects.show', $project->name, ['project' => $project->id], ['class' => 'bold']) !!}
            </td>
            <td class="tablet-hide">
                {!! @$project->street !!}<br>{!! $project->city . ', ' . $project->state . ' ' . $project->zip_code !!}
            </td>
            <td class="mobile-hide">
                {!! $project->size ? number_format($project->size, 0, '.', ',') . ' ' . $project->size_unit : 'N/A' !!}
            </td>
            <td class="mobile-hide">${!! number_format($project->value, 0, '.', ',') !!}</td>
            <td class="mobile-hide">{!! $project->status !!}</td>
            <td>
                {!! link_to_route('projects.edit', 'Edit', ['project' => $project->id], array('class' => 'btn btn-xs btn-default')) !!}
            </td>
          </tr>
          @endforeach
        </tbody>
      </table>
    </div>
  </div>
@endif