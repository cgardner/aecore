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
          <th>Address</th>
          <th>Size</th>
          <th>Value</th>
          <th>Status</th>
          <th></th>
        </thead>
        <tbody>
          @foreach($projects as $project)
          <tr>
            <td style="text-align:right;">{!! $project->number !!}</td>
            <td><a class="bold" href="#" title="Launch project.">{!! $project->name !!}</a></td>
            <td>{!! @$project->street !!}<br>{!! $project->city . ', ' . $project->state . ' ' . $project->zip_code !!}</td>
            <td>{!! number_format($project->size, 0, '.', ',') . ' ' . $project->size_unit !!}</td>
            <td>{!! '$' . number_format($project->value, 0, '.', ',') !!}</td>
            <td>{!! $project->status !!}</td>
            <td>{!! link_to('projects/edit/' . $project->projectcode, 'Edit', array('class' => 'btn btn-xs btn-default')) !!}</td>
          </tr>
          @endforeach
        </tbody>
      </table>
    </div>
  </div>
@endif

<ul class="pagination pull-right">
  <li class="disabled"><a href="#"><span class="glyphicon glyphicon-chevron-left"></span></a></li>
  <li class="active"><a href="#">1</a></li>
  <li><a href="#">2</a></li>
  <li><a href="#">3</a></li>
  <li><a href="#"><span class="glyphicon glyphicon-chevron-right"></span></a></li>
</ul>