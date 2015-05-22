@extends('layouts.application.main')
@section('content')

  <div class="pagehead">
    <a href="/projects/create" type="button" class="btn btn-default btn-success pull-right"><span class="glyphicon glyphicon-plus" aria-hidden="true"></span> Add Project</a>
    <h1>Projects</h1>
  </div>

  <p>IGNORE BELOW FOR NOW..</p>
  
 <!-- start block for side filter panel -->
	<div class="row">
		<div class="col-md-3">
      <div class="panel panel-default">
        <div class="panel-body">
          <!-- @include('projects.partials.project_filter') -->
        </div>
      </div>
		</div>
<!-- end block for side filter panel -->
		<div class="col-sm-9">
      <div class="panel panel-default">
          <div class="panel-body">
          <div class="row">
          <div class="btn-toolbar" role="toolbar" aria-label="...">
              <!-- Print button -->
              <button type="button" class="btn btn-default pull-right"  aria-label="Print" style="margin-right:30px">
                  <span class="glyphicon glyphicon-print" aria-hidden="true"></span> Print
              </button>
              <!-- Split button -->
              <div class="btn-group pull-right">
                <button type="button" class="btn btn-default">Sort</button>
                <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                  <span class="caret"></span>
                  <span class="sr-only">Toggle Dropdown</span>
                </button>
                <ul class="dropdown-menu" role="menu">
                  <li><a href="#">Newest</a></li>
                  <li><a href="#">Oldest</a></li>
                </ul>
              </div>
              <!-- Split button -->
              <div class="btn-group pull-right">
                <button type="button" class="btn btn-default">Export</button>
                <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                  <span class="caret"></span>
                  <span class="sr-only">Toggle Dropdown</span>
                </button>
                <ul class="dropdown-menu" role="menu">
                  <li><a href="#">Excel</a></li>
                  <li><a href="#">PDF</a></li>
                  <li><a href="#">JSON</a></li>

                </ul>
              </div>

          </div>
        <div class="row">
          <div class="panel-body">
            <!-- @include('projects.partials.project_list_data_grid') -->
        </div>
        </div>
  </div>
</div>
		</div>
	</div>
@endsection