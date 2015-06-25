<script type="text/javascript">
    $('input#search').quicksearch('table tbody tr');
</script>

@if(count($projects) == 0)
  <div class="alert alert-info">
    <p class="bold"><span class="glyphicon glyphicon-warning-sign"></span> No projects were found.</p>
    <p>Try changing your filter or create a <a href="/projects/create" class="btn btn-success btn-xs"><span class="glyphicon glyphicon-plus"></span> New Project</a> to get started.</p>
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
          @if($project->access == 'admin')
              <th></th>
          @endif
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
            @if($project->access == 'admin')
                <td>
                    {!! link_to_route('projects.edit', 'Edit', ['project' => $project->id], array('class' => 'btn btn-xs btn-default')) !!}
                </td>
            @endif
          </tr>
          @endforeach
        </tbody>
      </table>
    </div>
  </div>
@endif